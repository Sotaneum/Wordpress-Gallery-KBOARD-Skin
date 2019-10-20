<div id="kboard-thumbnail-list">

	<!-- 검색폼 시작 -->
	<div class="kboard-header">
		<form id="kboard-search-form" method="get" action="<?php echo $url->set('mod', 'list')->toString()?>">
			<?php echo $url->set('category1', '')->set('category2', '')->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
			
			<?php if($board->use_category == 'yes'):?>
			<div class="kboard-category">
				<?php if($board->initCategory1()):?>
					<select name="category1" onchange="jQuery('#kboard-search-form').submit();">
						<option value=""><?php echo __('All', 'kboard')?></option>
						<?php while($board->hasNextCategory()):?>
						<option value="<?php echo $board->currentCategory()?>"<?php if($_GET['category1'] == $board->currentCategory()):?> selected="selected"<?php endif?>><?php echo $board->currentCategory()?></option>
						<?php endwhile?>
					</select>
				<?php endif;?>
				
				<?php if($board->initCategory2()):?>
					<select name="category2" onchange="jQuery('#kboard-search-form').submit();">
						<option value=""><?php echo __('All', 'kboard')?></option>
						<?php while($board->hasNextCategory()):?>
						<option value="<?php echo $board->currentCategory()?>"<?php if($_GET['category2'] == $board->currentCategory()):?> selected="selected"<?php endif?>><?php echo $board->currentCategory()?></option>
						<?php endwhile?>
					</select>
				<?php endif;?>
			</div>
			<?php endif?>
			
			<div class="kboard-search">
				<select name="target">
					<option value=""><?php echo __('All', 'kboard')?></option>
					<option value="title"<?php if($_GET['target'] == 'title'):?> selected="selected"<?php endif?>><?php echo __('Title', 'kboard')?></option>
					<option value="content"<?php if($_GET['target'] == 'content'):?> selected="selected"<?php endif?>><?php echo __('Content', 'kboard')?></option>
					<option value="member_display"<?php if($_GET['target'] == 'member_display'):?> selected="selected"<?php endif?>><?php echo __('Author', 'kboard')?></option>
				</select>
				<input type="text" name="keyword" value="<?php echo $_GET['keyword']?>">
				<button type="submit" class="kboard-thumbnail-button-small"><?php echo __('Search', 'kboard')?></button>
			</div>
		</form>
	</div>
	<!-- 검색폼 끝 -->
	
	<!-- 리스트 시작 -->
	<div class="kboard-list">
		<table>
			<thead>
				<tr>
					<td class="kboard-list-uid"><?php echo __('Number', 'kboard')?></td>
					<td class="kboard-list-title"><?php echo __('Title', 'kboard')?></td>
					<td class="kboard-list-user"><?php echo __('Author', 'kboard')?></td>
					<td class="kboard-list-date"><?php echo __('Date', 'kboard')?></td>
					<td class="kboard-list-view"><?php echo __('Views', 'kboard')?></td>
				</tr>
			</thead>
			<tbody>
				<?php 
				$check=0;
				while($content = $list->hasNextNotice()):
				$check=1;
				?>
				<tr class="kboard-list-notice">
					<td class="kboard-list-uid"><?php echo __('Notice', 'kboard')?></td>
					<td class="kboard-list-title"><div class="cut_strings">
							<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>"><?php echo $content->title?></a>
							<?php echo $content->getCommentsCount()?>
						</div></td>
					<td class="kboard-list-user"><?php echo $content->member_display?></td>
					<td class="kboard-list-date"><?php echo date("Y.m.d", strtotime($content->date))?></td>
					<td class="kboard-list-view"><?php echo $content->view?></td>
				</tr>
				<?php endwhile?>
				<?php
				if($check==0)
				{
					echo "<tr>
							<td></td>
							<td><center>공지사항이 없습니다.</center></td>
							<td>관리자</td>
							<td></td>
							<td></td>";
				}
				
				?>
			</tbody>
			<table style="border:0px solid #ffffff ;" border="0" cellspacing="0" cellpadding="0">
				<?php
					$index=0;
					while($content = $list->hasNext()):
					$array[$index]['num']=$list->index();
					$array[$index]['thumbnail']=$content->thumbnail_file;	
					/*
						<?php if($content->thumbnail_file):?><img src="<?php echo kboard_resize($content->thumbnail_file, 120, 90)?>" style="max-width: 100px;" alt="<?php echo $content->thumbnail_name?>"><?php else:?><i class="icon-picture"></i><?php endif?>
					*/
					//echo kboard_resize($content->thumbnail_file, 120, 90)
					$array[$index]['title']=$content->title;
					$array[$index]['url']=$content->uid;
					/*
					<div class="cut_strings"><a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>"><?php echo $content->title?>
							<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon_lock.png" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
							</a>
							<?php echo $content->getCommentsCount()?>
						</div>
					
					*/
					$array[$index]['user']=$content->member_display;
					$array[$index]['date']=date("Y.m.d", strtotime($content->date));
					$array[$index]['view']=$content->view;
					$array[$index]['secret']=$content->secret;
					//$array[$index]['']
					$index=$index+1;
				 endwhile?>
				 <?php
					$size=$index;
					$page_max=0;
					$line=0;
					while($size>0){
						$line++;
						$size-=4;
					}
					for(;$line>0;$line--):
						?>
						<tr style="border:1px solid #ffffff ;" border="0" cellspacing="0" cellpadding="0">
							<?php
							for($i=0;$i<4;$i++)
							{
								if($index>$page_max){
								?>
								<td>
									<table style="border:0px solid #ffffff ;" border="0" cellspacing="0" cellpadding="0" onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#C6C6C6'">
									<?
									/*
									echo "
										<tr>
											<td>
												php echo $array[$index]['num']
											</td>
										</tr>"*/
										?>
										<tr>
											<td>
												<a href="<?php echo $url->set('uid', $array[$page_max]['url'])->set('mod', 'document')->toString()?>"><?php if($array[$page_max]['thumbnail']):?><img src="<?php echo kboard_resize($array[$page_max]['thumbnail'], 240, 180)?>" style="max-width: 200px;" alt="<?php echo $array[$page_max]['thumbnail']?>"><?php else:?><i class="icon-picture"></i><?php endif?></a>
											</td>
										</tr>
										<tr>
											<td>
												<div class="cut_strings"><a href="<?php echo $url->set('uid', $array[$page_max]['url'])->set('mod', 'document')->toString()?>"><?php echo $array[$page_max]['title']?>
												<?php if($array[$page_max]['secret']):?><img src="<?php echo $skin_path?>/images/icon_lock.png" style="max-width: 10px;" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
												</a>
												<?php //echo $content->getCommentsCount()?>
											</div>
											</td>
										</tr>
									</table>
								</td>
								<?php
								$page_max++;
								}
							}
							?>
						</tr>
						<?php
						$size=$size+1;
					endfor
				 ?>
			</table>
		</table>
	</div>
	<!-- 리스트 끝 -->
	
	<!-- 페이징 시작 -->
	<div class="kboard-pagination">
		<ul class="kboard-pagination-pages">
			<?php echo kboard_pagination($list->page, $list->total, $list->rpp)?>
		</ul>
	</div>
	<!-- 페이징 끝 -->
	
	<?php if($board->isWriter()):?>
	<!-- 버튼 시작 -->
	<div class="kboard-control">
		<a href="<?php echo $url->set('mod', 'editor')->toString()?>" class="kboard-thumbnail-button-small"><?php echo __('New', 'kboard')?></a>
	</div>
	<!-- 버튼 끝 -->
	<?php endif?>
	
	<div class="kboard-thumbnail-poweredby">
		<a href="http://blog.naver.com/cyydo96" onclick="window.open(this.href); return false;" title="<?php echo "Good Luck"?>">Powered by LeeDonggun</a>
	</div>
</div>