<div class='wrap'>
	<h2>Configurações do Youtube</h2>
	<form method='POST' action='edit.php?post_type=video&page=viagemcultural_video_options'>
		<p>Periodicamente, vídeos do canal configurado abaixo são adicionados automaticamente ao site.</p>
		<table class='form-table'>
			<tbody>
				<tr valign='top'>
					<th scope='row'>
						Canal
					</th>
					<td>
						<input type='text' size=30 name='viagemcultural_video_options[channel]' id='viagemcultural_video_options-channel' value='<?php echo $options['channel'] ?>' />
						<p class='description'>nome do canal no Youtube dos quais os vídeos serão obtidos.</p>
					</td>
				</tr>
					<tr valign='top'>
						<th scope='row'>
							Importar vídeos
						</th>
						<td>
							<a href="<?php echo admin_url('edit.php?post_type=video&page=viagemcultural_video_options&import=1') ?>" 
							id="viagemcultural_video_options-import" class="button button-secondary">
								Iniciar importação 
							</a>
							<p class='description'>isto irá importar qualquer vídeo do canal acima que já não tenha sido importado.</p>
						</td>
					</tr>
				</tbody>
			</table>
		<?php submit_button(); ?>
	</form>
</div>