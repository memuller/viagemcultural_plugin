# DRUPAL-TO-WORDPRESS CONVERSION SCRIPT

# Changelog

# 07.29.2010 - Updated by Scott Anderson / Room 34 Creative Services http://blog.room34.com/archives/4530
# 02.06.2009 - Updated by Mike Smullin http://www.mikesmullin.com/development/migrate-convert-import-drupal-5-to-wordpress-27/
# 05.15.2007 - Updated by D’Arcy Norman http://www.darcynorman.net/2007/05/15/how-to-migrate-from-drupal-5-to-wordpress-2/
# 05.19.2006 - Created by Dave Dash http://spindrop.us/2006/05/19/migrating-from-drupal-47-to-wordpress/

# This assumes that WordPress and Drupal are in separate databases, named 'wordpress' and 'drupal'.
# If your database names differ, adjust these accordingly.

# Empty previous content from WordPress database.
TRUNCATE TABLE wp_comments;
TRUNCATE TABLE wp_links;
TRUNCATE TABLE wp_postmeta;
TRUNCATE TABLE wp_posts;
TRUNCATE TABLE wp_term_relationships;
TRUNCATE TABLE wp_term_taxonomy;
TRUNCATE TABLE wp_terms;

# TAGS
# Using REPLACE prevents script from breaking if Drupal contains duplicate terms.
REPLACE INTO wp_terms
	(term_id, `name`, slug, term_group)
	SELECT DISTINCT
		d.tid, d.name, REPLACE(LOWER(d.name), ' ', '_'), 0
	FROM term_data d
	INNER JOIN term_hierarchy h
		USING(tid)
	INNER JOIN term_node n
		USING(tid)
	WHERE (1
	 	# This helps eliminate spam tags from import; uncomment if necessary.
	 	# AND LENGTH(d.name) < 50
	)
;

INSERT INTO wp_term_taxonomy
	(term_id, taxonomy, description, parent)
	SELECT DISTINCT
		d.tid `term_id`,
		'post_tag' `taxonomy`,
		d.description `description`,
		h.parent `parent`
	FROM term_data d
	INNER JOIN term_hierarchy h
		USING(tid)
	INNER JOIN term_node n
		USING(tid)
	WHERE (1
	 	# This helps eliminate spam tags from import; uncomment if necessary.
	 	# AND LENGTH(d.name) < 50
	)
;

# POSTS
# Keeps private posts hidden.
INSERT INTO wp_posts
	(id, post_author, post_date, post_content, post_title, post_excerpt,
	post_name, post_modified, post_type, `post_status`, to_ping, pinged, post_content_filtered)
	SELECT DISTINCT
		n.nid `id`,
		n.uid `post_author`,
		FROM_UNIXTIME(n.created) `post_date`,
		r.body `post_content`,
		n.title `post_title`,
		r.teaser `post_excerpt`,
		IF(SUBSTR(a.dst, 11, 1) = '/', SUBSTR(a.dst, 12), a.dst) `post_name`,
		FROM_UNIXTIME(n.changed) `post_modified`,
		n.type `post_type`,
		IF(n.status = 1, 'publish', 'private') `post_status`,
		'', '', ''
	FROM node n
	INNER JOIN node_revisions r
		USING(vid)
	LEFT OUTER JOIN url_alias a
		ON a.src = CONCAT('node/', n.nid)
	# Add more Drupal content types below if applicable.
	WHERE n.type IN ('post', 'page', 'blog', 'proximaparada', 'javisitamos', 'culinaria', 'melhores_momentos', 'melhores_momentos_internacionais', 'melhores_momentos_internacionais')
;

# Fix post type; http://www.mikesmullin.com/development/migrate-convert-import-drupal-5-to-wordpress-27/#comment-17826
# Add more Drupal content types below if applicable.
UPDATE wp_posts
	SET post_type = 'post'
	WHERE post_type IN ('blog')
;

# Set all pages to "pending".
# If you're keeping the same page structure from Drupal, comment out this query
# and the new page INSERT at the end of this script.
UPDATE wp_posts SET post_status = 'pending' WHERE post_type = 'page';

# POST/TAG RELATIONSHIPS
INSERT INTO wp_term_relationships (object_id, term_taxonomy_id)
	SELECT DISTINCT nid, tid FROM term_node
;

# Update tag counts.
UPDATE wp_term_taxonomy tt
	SET `count` = (
		SELECT COUNT(tr.object_id)
		FROM wp_term_relationships tr
		WHERE tr.term_taxonomy_id = tt.term_taxonomy_id
	)
;

# COMMENTS
# Keeps unapproved comments hidden.
# Incorporates change noted here: http://www.mikesmullin.com/development/migrate-convert-import-drupal-5-to-wordpress-27/#comment-32169
INSERT INTO wp_comments
	(comment_post_ID, comment_date, comment_content, comment_parent, comment_author,
	comment_author_email, comment_author_url, comment_approved)
	SELECT DISTINCT
		nid, FROM_UNIXTIME(timestamp), comment, thread, name,
		mail, homepage, ((status + 1) % 2)
	FROM comments
;

# Update comments count on wp_posts table.
UPDATE wp_posts
	SET `comment_count` = (
		SELECT COUNT(`comment_post_id`)
		FROM wp_comments
		WHERE wp_posts.`id` = wp_comments.`comment_post_id`
	)
;

# Fix images in post content; uncomment if you're moving files from "files" to "wp-content/uploads".
# UPDATE wp_posts SET post_content = REPLACE(post_content, '"/files/', '"/wp-content/uploads/');

# Fix taxonomy; http://www.mikesmullin.com/development/migrate-convert-import-drupal-5-to-wordpress-27/#comment-27140
UPDATE IGNORE wp_term_relationships, wp_term_taxonomy
	SET wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
	WHERE wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_id
;

