<!DOCTYPE html>
<html lang='en'>

<head>
	<meta charset='UTF-8'>
	<title>Categories</title>
	<meta name='description' content='The small framework with powerful features'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<link rel='shortcut icon' type='image/png' href='/favicon.ico' />
	<style>
		body {
			margin-bottom: 6em;
		}

		.treeview .btn-default {
			border-color: #e3e5ef;
		}

		.treeview .btn-default:hover {
			background-color: #f7faea;
			color: #bada55;
		}

		.treeview ul {
			list-style: none;
			padding-left: 32px;
		}

		.treeview ul li {
			padding: 50px 0px 0px 35px;
			position: relative;
		}

		.treeview ul li:before {
			content: '';
			position: absolute;
			top: -26px;
			left: -31px;
			border-left: 2px dashed #a2a5b5;
			width: 1px;
			height: 100%;
		}

		.treeview ul li:after {
			content: '';
			position: absolute;
			border-top: 2px dashed #a2a5b5;
			top: 70px;
			left: -30px;
			width: 65px;
		}

		.treeview ul li:last-child:before {
			top: -22px;
			height: 90px;
		}

		.treeview>ul>li:after,
		.treeview>ul>li:last-child:before {
			content: unset;
		}

		.treeview>ul>li:before {
			top: 90px;
			left: 36px;
		}

		.treeview>ul>li:not(:last-child)>ul>li:before {
			content: unset;
		}

		.treeview>ul>li>.treeview__level:before {
			height: 60px;
			width: 60px;
			top: -9.5px;
			background-color: #54a6d9;
			border: 7.5px solid #d5e9f6;
			font-size: 22px;
		}

		.treeview>ul>li>ul {
			padding-left: 34px;
		}

		.treeview__level {
			padding: 7px;
			padding-left: 42.5px;
			display: inline-block;
			border-radius: 5px;
			font-weight: 700;
			border: 1px solid #e3e5ef;
			position: relative;
			z-index: 1;
		}

		.treeview__level:before {
			content: attr(data-level);
			position: absolute;
			left: -27.5px;
			top: -6.5px;
			display: flex;
			align-items: center;
			justify-content: center;
			height: 55px;
			width: 55px;
			border-radius: 50%;
			border: 7.5px solid #eef6d5;
			background-color: #bada55;
			color: #fff;
			font-size: 20px;
		}

		.treeview__level-btns {
			margin-left: 15px;
			display: inline-block;
			position: relative;
		}

		.treeview__level .level-same,
		.treeview__level .level-sub {
			min-width: 140px;
			position: absolute;
			display: none;
			transition: opacity 250ms cubic-bezier(0.7, 0, 0.3, 1);
		}

		.treeview__level .level-same.in,
		.treeview__level .level-sub.in {
			display: block;
		}

		.treeview__level .level-same.in .btn-default,
		.treeview__level .level-sub.in .btn-default {
			background-color: #faeaea;
			color: #da5555;
		}

		.treeview__level .level-same {
			top: 0;
			left: 45px;
		}

		.treeview__level .level-sub {
			top: 42px;
			left: 0px;
		}

		.treeview__level .level-remove {
			display: none;
		}

		.treeview__level.selected {
			background-color: #f9f9fb;
			box-shadow: 0px 3px 15px 0px rgba(0, 0, 0, 0.1);
		}

		.treeview__level.selected .level-remove {
			display: inline-block;
		}

		.treeview__level.selected .level-add {
			display: none;
		}

		.treeview__level.selected .level-same,
		.treeview__level.selected .level-sub {
			display: none;
		}

		.treeview .level-title {
			cursor: pointer;
			user-select: none;
		}

		.treeview .level-title:hover {
			text-decoration: underline;
		}

		.treeview--mapview ul {
			justify-content: center;
			display: flex;
		}

		.treeview--mapview ul li:before {
			content: unset;
		}

		.treeview--mapview ul li:after {
			content: unset;
		}
	</style>
	<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' integrity='sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh' crossorigin='anonymous'>
	<script src='https://code.jquery.com/jquery-3.5.1.min.js' integrity='sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=' crossorigin='anonymous'></script>
	<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>

</head>

<body>
	<?php
		function echo_categories($categories) {
			foreach($categories as $category) {
				$parentId = $category->parent_id ?? 0; 
				echo "<li>\n";
					echo "<div class='treeview__level' data-level='{$category->depth}' data-id='{$category->id}' data-parent-id='{$parentId}'>\n
						<span class='level-title'>{$category->name}</span>\n
						<div class='treeview__level-btns'>\n
							<div class='btn btn-default btn-sm level-add'><span class='fa fa-plus'></span></div>\n
							<div class='btn btn-default btn-sm level-remove'><span class='fa fa-trash text-danger'></span></div>\n
							<div class='btn btn-default btn-sm level-same'><span>Add Same Level</span></div>\n
							<div class='btn btn-default btn-sm level-sub'><span>Add Sub Level</span></div>\n
						</div>\n
					</div>\n";
					
					$subCategories   = \Config\Database::connect()->table('categories')->where(['parent_id'=> $category->id])->orderBy('seq ASC')->get()->getResult();
					if(count($subCategories)){
						echo "<ul>\n";
							echo_categories($subCategories);
						echo "</ul>\n";
					}
					
				echo "</li>\n";
			}
		}
	?>
	<div class='treeview js-treeview'>
		<ul>
			<?php echo_categories($mainCategories) ?>
		</ul>
		
	</div>

	<template id='levelMarkup'>
		<li>
			<div class='treeview__level' data-level='0' data-parent-id='', data-id=''>
				<span class='level-title'>Level A</span>
				<div class='treeview__level-btns'>
					<div class='btn btn-default btn-sm level-add'><span class='fa fa-plus'></span></div>
					<div class='btn btn-default btn-sm level-remove'><span class='fa fa-trash text-danger'></span></div>
					<div class='btn btn-default btn-sm level-same'><span>Add Same Level</span></div>
					<div class='btn btn-default btn-sm level-sub'><span>Add Sub Level</span></div>
				</div>
			</div>
			<ul>
			</ul>
		</li>
	</template>

	<script>
		$(function() {
			let treeview = {
				resetBtnToggle: function() {
					$('.js-treeview')
						.find('.level-add')
						.find('span')
						.removeClass()
						.addClass('fa fa-plus');
					$('.js-treeview')
						.find('.level-add')
						.siblings()
						.removeClass('in');
				},
				addSameLevel: function(target) {
					id = target.closest('[data-parent-id]').attr('data-parent-id');					
					$.ajax({
						url: '/category/addSubLevel/'+id,
						context: document.body,
						dataType : 'json',
					}).done(function(data) {
						
						let ulElm = target.closest('ul');
						ulElm.append($('#levelMarkup').html());
						ulElm
							.children('li:last-child')
							.find('[data-level]')
							.attr('data-level', data.depth);
						ulElm
							.children('li:last-child')
							.find('[data-id]')
							.attr('data-id', data.id);
						ulElm
							.children('li:last-child')
							.find('[data-parent-id]')
							.attr('data-parent-id', id);
						ulElm
							.children('li:last-child')
							.find('.level-title')
							.html(data.name);
					});	
				},
				addSubLevel: function(target) {
					id = target.closest('[data-id]').attr('data-id');					
					$.ajax({
						url: '/category/addSubLevel/'+id,
						context: document.body,
						dataType : 'json',
					}).done(function(data) {
						let liElm = target.closest('li');
						if(liElm.find('ul').length == 0)
							liElm.append('<ul></ul>');
						let nextLevelCodeASCII = liElm.find('[data-level]').attr('data-level') + 1;
						liElm.children('ul').append($('#levelMarkup').html());
						liElm.children('ul').find('[data-level]')
							.attr('data-level', data.depth);
						liElm.children('ul').find('[data-id]')
							.attr('data-id', data.id);
						liElm.children('ul').find('[data-parent-id]')
							.attr('data-parent-id', id);
						liElm.children('ul').find('.level-title')
							.html(data.name);							
					});	
				}
			};

			// Treeview Functions
			$('.js-treeview').on('click', '.level-add', function() {
				$(this).find('span').toggleClass('fa-plus').toggleClass('fa-times text-danger');
				$(this).siblings().toggleClass('in');
			});

			// Add same level
			$('.js-treeview').on('click', '.level-same', function() {
				treeview.addSameLevel($(this));
				treeview.resetBtnToggle();
			});

			// Add sub level
			$('.js-treeview').on('click', '.level-sub', function() {
				treeview.addSubLevel($(this));
				treeview.resetBtnToggle();
			});
			// Remove Level
			// $('.js-treeview').on('click', '.level-remove', function() {
			// 	treeview.removeLevel($(this));
			// });

			// Selected Level
			// $('.js-treeview').on('click', '.level-title', function() {
			// 	let isSelected = $(this).closest('[data-level]').hasClass('selected');
			// 	!isSelected && $(this).closest('.js-treeview').find('[data-level]').removeClass('selected');
			// 	$(this).closest('[data-level]').toggleClass('selected');
			// });
		});	
	</script>
</body>

</html>