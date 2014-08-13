
<?php echo Asset::js(array('jquery-1.11.1.js', 'ajax.js')); ?>

<?php echo $errmsg ?>

<p>最終更新:<span id="last-update"><?php echo $last_update; ?></span></p>

<?php echo Form::open(array(
					'action' => '/home/create',
					'name'=>'upload',
					'enctype'=>'multipart/form-data',
					'method'=>'post')); ?>
	<div>
		<?php echo Form::textarea('content', 'ここにつぶやく内容をどうぞ', 
			array(
				'style' => 'border-color: #000000;',
				'rows' => 6,
				'cols' => 30
					)); ?>
	</div>
	<div>
		<?php echo Form::file('upload',array('class'=>'span4')); ?>
	</div>
	<?php echo Form::submit('submit', 'つぶやく'); ?>
<?php echo Form::close(); ?>

<ul id="timeline">
	<?php foreach($user_tweets as $tweet): ?>
		<li>
			<p>投稿者:<?php echo $tweet['username'] ?></p>
			<p><?php echo $tweet['content'] ?></p>
			<p>投稿日時:<?php echo $tweet['created_at'] ?></p>
			<?php 	if(!empty($tweet['image_path']))
					echo Asset::img($tweet['image_path'],array('alt'=>'画像')); ?>
			<?php if($tweet['user_id'] == $user_id): ?>
				<p><?php echo Html::anchor("/home/delete/".$tweet['id'], "削除する"); ?></p>
			<?php endif; ?>
		</li>	
	<?php endforeach; ?>
</ul>



<p><?php echo Html::anchor('login/logout', 'ログアウト'); ?></p>