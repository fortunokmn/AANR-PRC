<?php
/*
Template name: PinBoxes
URI: http://www.projectsend.org/templates/pinboxes
Author: ProjectSend
Author URI: http://www.projectsend.org/
Author e-mail: contact@projectsend.org
Description: Inspired by the awesome design of Pinterest!
*/
$ld = 'pinboxes_template'; // specify the language domain for this template

define('TEMPLATE_RESULTS_PER_PAGE', -1);

if ( !empty( $_GET['category'] ) ) {
	$category_filter = $_GET['category'];
}

include_once(ROOT_DIR.'/templates/common.php'); // include the required functions for every template

$window_title = __('Available files','pinboxes_template');

$count = count($my_files);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo html_output( $client_info['name'].' | '.$window_title . ' &raquo; ' . SYSTEM_NAME ); ?></title>
		<link rel="stylesheet" media="all" type="text/css" href="<?php echo $this_template; ?>main.css" />
		<?php meta_favicon(); ?>
		<link href='<?php echo PROTOCOL; ?>://fonts.googleapis.com/css?family=Metrophobic' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo $this_template; ?>/font-awesome-4.6.3/css/font-awesome.min.css">
		
		<script src="<?php echo PROTOCOL; ?>://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo $this_template; ?>/js/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="<?php echo $this_template; ?>/js/imagesloaded.pkgd.min.js"></script>

		

		<script type="text/javascript">
			$(document).ready(function()
				{
					var $container = $('.photo_list');
					$container.imagesLoaded(function(){
						$container.masonry({
							itemSelector	: '.photo',
							columnWidth		: '.photo'
						});
					});

					$('.button').click(function() {
						$(this).blur();
					});
					
					$('.categories_trigger a').click(function(e) {
						if ( $('.categories').hasClass('visible') ) {
							close_menu();
						}
						else {
							open_menu();
						}
					});
					
					$('.content_cover').click(function(e) {
						close_menu();
					});
					
					function open_menu() {
						$('.categories').addClass('visible');
						$('.categories').stop().slideDown();
						$('.content_cover').stop().fadeIn(200);
					}

					function close_menu() {
						$('.categories').removeClass('visible');
						$('.content_cover').stop().fadeOut(200);
						$('.categories').stop().slideUp();
					}
				}
			);
		</script>


		<style>
			/* Style the Image Used to Trigger the Modal */
			.myImg {
			    border-radius: 5px;
			    cursor: pointer;
			    transition: 0.3s;
			}

			.myImg:hover {opacity: 0.7;}

			/* The Modal (background) */
			.modal {
			    display: none; /* Hidden by default */
			    position: fixed; /* Stay in place */
			    z-index: 1; /* Sit on top */
			    padding-top: 100px; /* Location of the box */
			    left: 0;
			    top: 0;
			    width: 100%; /* Full width */
			    height: 100%; /* Full height */
			    overflow: auto; /* Enable scroll if needed */
			    background-color: rgb(0,0,0); /* Fallback color */
			    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
			}

			/* Modal Content (Image) */
			.modal-content {
			    margin: auto;
			    display: block;
			    width: 80%;
			    max-width: 700px;
			}

			/* Caption of Modal Image (Image Text) - Same Width as the Image */
			#caption {
			    margin: auto;
			    display: block;
			    width: 80%;
			    max-width: 700px;
			    text-align: center;
			    color: #ccc;
			    padding: 10px 0;
			    height: 150px;
			}

			/* Add Animation - Zoom in the Modal */
			.modal-content, #caption {
			    -webkit-animation-name: zoom;
			    -webkit-animation-duration: 0.6s;
			    animation-name: zoom;
			    animation-duration: 0.6s;
			}

			@-webkit-keyframes zoom {
			    from {-webkit-transform:scale(0)}
			    to {-webkit-transform:scale(1)}
			}

			@keyframes zoom {
			    from {transform:scale(0)}
			    to {transform:scale(1)}
			}

			/* The Close Button */
			.close {
			    position: absolute;
			    top: 15px;
			    right: 35px;
			    color: #f1f1f1;
			    font-size: 40px;
			    font-weight: bold;
			    transition: 0.3s;
			}

			.close:hover,
			.close:focus {
			    color: #bbb;
			    text-decoration: none;
			    cursor: pointer;
			}

			/* 100% Image Width on Smaller Screens */
			@media only screen and (max-width: 700px){
			    .modal-content {
			        width: 100%;
			    }
			}
		</style>

	</head>
	
	<body>
		<div id="header">
			<?php if ($logo_file_info['exists'] === true) { ?>
				<div id="branding">
					<img src="<?php echo TIMTHUMB_URL; ?>?src=<?php echo $logo_file_info['url']; ?>&amp;w=300" alt="<?php echo html_output(THIS_INSTALL_SET_TITLE); ?>" />
				</div>
			<?php } ?>
		</div>

		<div id="menu">
			<p class="welcome">
				<?php _e('Welcome','pinboxes_template'); ?>, <?php echo html_output($client_info['name']); ?>
			</p>
			<ul>
				<li id="search_box">
					<form action="" name="files_search" method="get">
						<input type="text" name="search" id="search_text" value="<?php echo (isset($_GET['search']) && !empty($_GET['search'])) ? html_output($_GET['search']) : ''; ?>" placeholder="<?php _e('Search...','pinboxes_template'); ?>">
						<button type="submit" id="search_go"><i class="fa fa-search" aria-hidden="true"></i></button>
					</form>
				</li>
				<?php
					if ( !empty( $get_categories['categories'] ) ) {
						$url_client_id	= ( !empty($_GET['client'] ) && CURRENT_USER_LEVEL != '0') ? $_GET['client'] : null;
						$link_template	= BASE_URI . 'my_files/';
				?>
						<li class="categories_trigger">
							<a href="#" target="_self"><i class="fa fa-filter" aria-hidden="true"></i> <?php _e('Categories', 'pinboxes_template'); ?></a>
							<ul class="categories">
								<li class="filter_all_files"><a href="<?php echo BASE_URI . 'my_files/'; if ( !empty( $url_client_id ) ) { echo '?client=' . $url_client_id; }; ?>"><?php  _e('All files', 'pinboxes_template'); ?></a></li>
								<?php
									foreach ( $get_categories['categories'] as $category ) {
										$link_data	= array(
																'client'	=> $url_client_id,
																'category'	=> $category['id'],
															);
										$link_query	= http_build_query($link_data);
								?>
										<li><a href="<?php echo $link_template . '?' . $link_query; ?>"><?php echo $category['name']; ?></a></li>
								<?php
									}
								?>							
							</ul>
						</li>
				<?php
					}
				?>
				<li>
					<a href="<?php echo BASE_URI; ?>upload-from-computer.php" target="_self"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?php _e('Upload files', 'pinboxes_template'); ?></a>
				</li>
				<li>
					<a href="<?php echo BASE_URI; ?>process.php?do=logout" target="_self"><i class="fa fa-sign-out" aria-hidden="true"></i> <?php _e('Logout', 'pinboxes_template'); ?></a>
				</li>
			</ul>
		</div>
			
		<div id="content">
			<div class="content_cover"></div>
			<div class="wrapper">
		
		<?php
			if (!$count) {
		?>
				<div class="no_files">
					<?php
						_e('There are no files.','pinboxes_template');
					?>
				</div>
		<?php
			}
			else {
		?>
				<div class="photo_list">
				<?php
					foreach ($my_files as $file) {
						$download_link = make_download_link($file);
						$date = date(TIMEFORMAT_USE,strtotime($file['timestamp']));
				?>
						<div class="photo <?php if ($file['expired'] == true) { echo 'expired'; } ?>">
							<div class="photo_int">
								<?php
									/**
									 * Generate the thumbnail if the file is an image.
									 */
									$pathinfo = pathinfo($file['url']);
									$extension = strtolower($pathinfo['extension']);
									$img_formats = array('gif','jpg','pjpeg','jpeg','png');
									if (in_array($extension,$img_formats)) {
								?>
										<div class="img_prev">

											<?php
												if ($file['expired'] == false) {
											?>
													<!-- <a href="<?php echo $download_link; ?>" target="_blank"> -->
														<?php
															$this_thumbnail_url = UPLOADED_FILES_URL.$file['url'];
															if (THUMBS_USE_ABSOLUTE == '1') {
																$this_thumbnail_url = BASE_URI.$this_thumbnail_url;
															}
														?>
														<img class="myImg" src="<?php echo TIMTHUMB_URL; ?>?src=<?php echo $this_thumbnail_url; ?>&amp;w=250&amp;q=<?php echo THUMBS_QUALITY; ?>" alt="<?php echo htmlentities($file['name']); ?>" />

														
														<!-- The Modal -->
														<div id="myModal" class="modal">

														  <!-- The Close Button -->
														  <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>

														  <!-- Modal Content (The Image) -->
														  <img class="modal-content" id="img01">

														  <!-- Modal Caption (Image Text) -->
														  <div id="caption"></div>
														</div>
													<!-- </a> -->
											<?php
												}
											?>
										</div>
								<?php
									} else {
										if ($file['expired'] == false) {
								?>
											<div class="ext_prev">
												<a href="<?php echo $download_link; ?>" target="_blank">
													<h6><?php echo $extension; ?></h6>
												</a>
											</div>
								<?php
										}
									}
								?>
							</div>
							<div class="img_data">
								<h2><?php echo htmlentities($file['name']); ?></h2>
								<div class="photo_info">
									<?php echo htmlentities_allowed($file['description']); ?>
									<p class="file_size">
										<?php
											$file_absolute_path = UPLOADED_FILES_FOLDER . $file['url'];
											if ( file_exists( $file_absolute_path ) ) {
												$this_file_size = format_file_size(get_real_size(UPLOADED_FILES_FOLDER.$file['url']));
												_e('File size:','pinboxes_template'); ?> <strong><?php echo $this_file_size; ?></strong>
										<?php
											}
										?>
									</p>

									<p class="exp_date">
										<?php
											if ( $file['expires'] == '1' ) {
												$exp_date = date( TIMEFORMAT_USE, strtotime( $file['expiry_date'] ) );
												_e('Expiration date:','pinboxes_template'); ?> <span><?php echo $exp_date; ?></span>
										<?php
											}
										?>
									</p>
								</div>
								<div class="download_link">
									<?php
										if ($file['expired'] == false) {
									?>
											<a href="<?php echo $download_link; ?>" target="_blank" class="button button_gray">
												<?php _e('Download','pinboxes_template'); ?>
											</a>
									<?php
										}
										else {
									?>
											<?php _e('File expired','pinboxes_template'); ?>
									<?php
										}
									?>
								</div>
							</div>
						</div>
					<?php
						}
					?>
				</div>
			<?php
			}
			?>
		
			</div>
	
			<?php default_footer_info(); ?>
	
		</div>

		<!-- image preview -->
		<script type="text/javascript" src="<?php echo $this_template; ?>/addedFeatures/imagePreview.js"></script>

	</body>
</html>