<?php
	use \lithium\util\Inflector;
	$base = $request->env('base');
?>
<!doctype html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="<?php echo $base; ?>/css/debug.css" />
		<link href="<?php echo $base; ?>/favicon.ico" type="image/x-icon" rel="icon" />
		<link href="<?php echo $base; ?>/favicon.ico" type="image/x-icon" rel="shortcut icon" />
	</head>
	<body class="test-dashboard">
		<div id="header">
			<header>
				<h1>
					<a href="<?php echo $base ?>/test/">
						<span class="triangle"></span> Lithium Unit Test Dashboard
					</a>
				</h1>
				<a class="test-all" href="<?php echo $base ?>/test/all">run all tests</a>
			</header>
		</div>

		<div class="article">
			<article>
				<div class="test-menu">
					<?php echo $report->render("menu", array("menu" => $menu, "base" => $base)) ?>
				</div>

				<div class="test-content">
					<?php if ($report->title) { ?>
						<h2><span>test results for </span><?php echo $report->title; ?></h2>
					<?php } ?>

					<span class="filters">
						<?php echo join('', array_map(
							function($class) use ($request) {
								$url = "?filters[]={$class}";
								$name = join('', array_slice(explode("\\", $class), -1));
								$key = Inflector::underscore($name);
								$isActive = (
									isset($request->query['filters']) &&
									array_search($class, $request->query['filters']) !== false
								);
								$active = $isActive ? 'active' : null;
								return "<a class=\"{$key} {$active}\" href=\"{$url}\">{$name}</a>";
							},
							$filters
						)); ?>
					</span>
					<?php
					echo $report->render("stats");

					foreach ($report->filters() as $filter => $options) {
						$data = $report->results['filters'][$filter];
						echo $report->render($options['name'], compact('data', 'base'));
					}
					?>
				</div>
			</article>
		</div>
		<div style="clear:both"></div>
	</body>
</html>