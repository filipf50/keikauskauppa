<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="Robots" content="all" />
	<meta name="MSSmartTagsPreventParsing" content="true" />
    <meta name="viewport" content="initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="author" content="Opencart-Templates" />

	<title><?php echo $title; ?></title>
</head>
<body style="width:100% !important; min-width:100%; height:100%; margin-top:0 !important; margin-right:0 !important; margin-bottom:0 !important; margin-left:0 !important; padding:0 !important; background:none !important; font-family:'Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif; font-size:14px; line-height:normal; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;" text="<?php echo $body_font_color; ?>" link="<?php echo $body_link_color; ?>" alink="<?php echo $body_link_color; ?>" vlink="<?php echo $body_link_color; ?>" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<table id="emailWrapper" style="table-layout:fixed; border-collapse:collapse; border:none; mso-table-lspace:0pt; mso-table-rspace:0pt; width:100%;" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="<?php echo $body_bg_color; ?>">	    	
    <?php if($head_text || $shadow_top): ?>
    <tr>
    	<td class="emailWrapper" bgcolor="<?php echo $body_bg_color; ?>" width="100%" style="width:100%; font-family:'Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif; font-size:14px; line-height:normal; color:<?php echo $body_font_color; ?>;">
    	
    	<table class="emailHead" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
			<tr>
				<td width="100%" align="center" valign="top" style="text-align:center; width:100%; vertical-align:top" bgcolor="<?php echo ($head_section_bg_color) ? $head_section_bg_color : $body_bg_color; ?>">					
					<center>
					<!--[if mso]>
						<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo $email_full_width; ?>" style="width:<?php echo $email_full_width; ?>; border:none; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
							<tr><td width="<?php echo $email_full_width; ?>" style="width:<?php echo $email_full_width; ?>px;">
					<![endif]-->
					<div style="max-width:<?php echo $email_full_width; ?>px; margin-left:auto; margin-right:auto;" align="center">												
					<table class="mainContainer" width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed; border:none; width:100%; max-width:<?php echo $email_full_width; ?>px; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">            				
            			<?php if($head_text): ?>
            			<tr>
            				<td width="100%" style="width:100%;">
            					<table class="emailHeadText" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:auto; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
									<tr>
										<td><?php echo $head_text; ?></td>
									</tr>
								</table>
            				</td>
            			</tr>
            			<?php endif; ?>
            			<tr>
            				<td width="100%" style="width:100%;">
                				<?php if($shadow_top): ?>
                				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                					<tr>
                						<td width="<?php echo $shadow_top_left_img_width; ?>" height="<?php echo $shadow_top_left_img_height; ?>" style="width:<?php echo $shadow_top_left_img_width; ?>px; height:<?php echo $shadow_top_left_img_height; ?>px; font-size:1px; line-height:0; vertical-align:top" valign="top">
                							<img src="<?php echo $shadow_top_left_img; ?>" width="<?php echo $shadow_top_left_img_width; ?>" height="<?php echo $shadow_top_left_img_height; ?>" alt="" style="border:none;" />
                						</td>	
                						<td valign="top" style="vertical-align:top">
                							<table class="emailShadow emailShadowTop" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
												<?php echo $shadow_top; ?>
												<tr>
													<td height="<?php echo $shadow_top_overlap; ?>" style="height:<?php echo $shadow_top_overlap; ?>px; font-size:1px; line-height:0; mso-margin-top-alt:1px; background-color:<?php echo $header_bg_color; ?>;" bgcolor="<?php echo $header_bg_color; ?>">&nbsp;</td>
												</tr>
											</table>
                						</td>
                						<td width="<?php echo $shadow_top_right_img_width; ?>" height="<?php echo $shadow_top_right_img_height; ?>" style="width:<?php echo $shadow_top_right_img_width; ?>px; height:<?php echo $shadow_top_right_img_height; ?>px; font-size:1px; line-height:0; vertical-align:top" valign="top">
                							<img src="<?php echo $shadow_top_right_img; ?>" width="<?php echo $shadow_top_right_img_width; ?>" height="<?php echo $shadow_top_right_img_height; ?>" alt="" style="border:none;" />
                						</td>
                					</tr>
								</table>								
								<?php endif; ?>
							</td>
						</tr>							
					</table>	
					</div>
					<!--[if mso]>
							</td></tr>
						</table>
					<![endif]-->	
					</center>
				</td>
			</tr>
		</table>
		
		</td>
	</tr>
    <?php endif; ?>	    	
    <tr>
    	<td class="emailWrapper" bgcolor="<?php echo $body_bg_color; ?>" width="100%" style="width:100%; font-family:'Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif; font-size:14px; line-height:normal; color:<?php echo $body_font_color; ?>;">
	    	<table class="emailHeader" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
				<tr>
					<td width="100%" align="center" valign="top" style="text-align:center; width:100%; vertical-align:top" bgcolor="<?php echo ($header_section_bg_color) ? $header_section_bg_color : $body_bg_color; ?>">
						<center>
						<!--[if mso]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo $email_full_width; ?>" style="width:<?php echo $email_full_width; ?>; border:none; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
								<tr><td width="<?php echo $email_full_width; ?>" style="width:<?php echo $email_full_width; ?>px;">
						<![endif]-->
						<div style="max-width:<?php echo $email_full_width; ?>px; margin-left:auto; margin-right:auto;" align="center">												
						<table class="mainContainer" width="100%" cellpadding="0" cellspacing="0" border="0" align="center" height="<?php echo $header_height; ?>" style="table-layout:fixed; border:none; height:<?php echo $header_height; ?>px; width:100%; max-width:<?php echo $email_full_width; ?>px; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">            				
            				<tr>
            					<?php if($shadow_left) echo $shadow_left; ?>
                				<td>                				
									<table class="emailHeader" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; <?php if($header_bg_image){ echo " background-image:url('".$header_bg_image."');"; } ?>background-color:<?php echo $header_bg_color; ?>;" <?php if($header_bg_image){ ?> background="<?php echo $header_bg_image; ?>"<?php } ?> bgcolor="<?php echo $header_bg_color; ?>">
                						<tr>
											<td width="100%" style="width:100%; height:<?php echo $header_height; ?>px;" height="<?php echo $header_height; ?>" valign="<?php echo $logo_valign; ?>" align="<?php echo $logo_align; ?>">												
			                					<?php if($header_bg_image){ ?>
												<!--[if gte mso 9]>
													<v:image xmlns:v="urn:schemas-microsoft-com:vml" id="HeaderImage" style='behavior:url(#default#VML);display:inline-block;position:absolute; height:<?php echo $header_height; ?>px; width:<?php echo $email_width; ?>px;top:0;left:0;border:0;z-index:1;' src="<?php echo $header_bg_image; ?>"/>
													<v:shape xmlns:v="urn:schemas-microsoft-com:vml" id="HeaderText" style='behavior:url(#default#VML);display:inline-block;position:absolute;visibility:visible;height:<?php echo $header_height-5; ?>px;width:<?php echo $email_width; ?>px;background-color:transparent;top:-5px;left:-10px;border:0;z-index:2;' stroked='f'>
													<div>										
												<![endif]-->
												<?php } ?>
												<table cellspacing="0" cellpadding="0" border="0" width="100%" height="<?php echo $header_height; ?>" style="width:100%; height:<?php echo $header_height; ?>px;">
													<tr>
														<td width="100%" style="width:100%; height:<?php echo $header_height; ?>px; text-align:<?php echo $logo_align; ?>; vertical-align:<?php echo $logo_valign; ?>" height="<?php echo $header_height; ?>" valign="<?php echo $logo_valign; ?>" align="<?php echo $logo_align; ?>">
															<a href="<?php echo (!empty($store_url) ? ($store_url.(strpos($store_url,'?')===false ? '?' : '&amp;')) : ($server.(strpos($server,'?')===false ? '?' : '&amp;'))).'utm_content=header_logo'; ?>" target="_blank" title="<?php echo $store_name; ?>" style="display:block; text-decoration:none; font-size:<?php echo $logo_font_size; ?>px; font-weight:bold; color:<?php echo $logo_font_color; ?>;">
																<?php if($logo): ?>
						        									<img class="emailLogo emailStretch" src="<?php echo $logo; ?>" alt="<?php echo $store_name; ?>" border="0" style="outline:none; text-decoration:none; -ms-interpolation-mode:bicubic; display:inline; border:none; max-width:100% !important;" height="<?php echo $logo_height; ?>" width="<?php echo $logo_width; ?>" />
						        								<?php else: ?>
						        				 					<?php echo $store_name; ?>
						        				 				<?php endif; ?>
					        				 				</a>
														</td>
													</tr>
												</table>
		        				 				<?php if($header_bg_image){ ?>
												<!--[if gte mso 9]>
													</div>
													</v:shape>
												<![endif]-->
												<?php } ?>											
											</td>
										</tr>
									</table>									
									<?php if($header_border_height > 0): ?>
									<table class="emailHeaderBorder" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgcolor="<?php echo $header_border_color; ?>">
										<tr>
											<td width="100%" height="<?php echo $header_border_height; ?>" align="center" valign="top" style="vertical-align:top; text-align:center; width:100%; font-size:1px; line-height:0; height:<?php echo $header_border_height; ?>px;">&nbsp;</td>
										</tr>
									</table>
									<?php endif; ?>						
								</td>
								<?php if($shadow_right) echo $shadow_right; ?>
							</tr>							
						</table>												
						</div>
						<!--[if mso]>
								</td></tr>
							</table>
						<![endif]-->	
						</center>																	 
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
    	<td class="emailWrapper" bgcolor="<?php echo $body_bg_color; ?>" width="100%" style="width:100%; font-family:'Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif; font-size:14px; line-height:normal; color:<?php echo $body_font_color; ?>;">	
	    	<table class="emailPage" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
				<tr>
					<td width="100%" align="center" valign="top" style="text-align:center; width:100%; vertical-align:top;" bgcolor="<?php echo ($body_section_bg_color) ? $body_section_bg_color : $body_bg_color; ?>">
						<center>
						<!--[if mso]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo $email_full_width; ?>" style="width:<?php echo $email_full_width; ?>; border:none; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
								<tr><td width="<?php echo $email_full_width; ?>" style="width:<?php echo $email_full_width; ?>px;">
						<![endif]-->
						<div style="max-width:<?php echo $email_full_width; ?>px; margin-left:auto; margin-right:auto;" align="center">												
						<table class="mainContainer" width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed; border:none; width:100%; max-width:<?php echo $email_full_width; ?>px; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" align="center">            				
            				<tr>
                				<?php if($shadow_left) echo $shadow_left; ?> 
                				<td>
									<table class="emailMainText" border="0" cellspacing="0" cellpadding="<?php echo $page_padding; ?>" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgcolor="<?php echo $page_bg_color; ?>">
                						<tr>
											<td style="padding:<?php echo $page_padding; ?>px; text-align:<?php echo $text_align; ?>; font-family:'Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif; font-size:14px; line-height:normal; color:<?php echo $body_font_color; ?>;" align="<?php echo $text_align; ?>">
												{CONTENT}
											</td>
										</tr>
										<?php if($page_footer_text && empty($showcase_selection)): ?>
                							<tr>
                								<td style="padding:<?php echo $page_padding; ?>px"><?php echo $page_footer_text; ?></td>
                							</tr>
										<?php endif; ?>
									</table>							
								</td>
								<?php if($shadow_right) echo $shadow_right; ?>
							</tr>							
						</table>												
						</div>
						<!--[if mso]>
								</td></tr>
							</table>
						<![endif]-->	
						</center>												 
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php if(!empty($showcase_selection)): ?>
	<tr>
    	<td class="emailWrapper" bgcolor="<?php echo $body_bg_color; ?>" width="100%" style="width:100%; font-family:'Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif; font-size:14px; line-height:normal; color:<?php echo $body_font_color; ?>;">	
	    	<table class="emailPage" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
				<tr>
					<td width="100%" align="center" valign="top" style="text-align:center; width:100%; vertical-align:top;" bgcolor="<?php echo ($showcase_section_bg_color) ? $showcase_section_bg_color : $body_bg_color; ?>">
						<center>
						<!--[if mso]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo $email_full_width; ?>" style="width:<?php echo $email_full_width; ?>; border:none; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
								<tr><td width="<?php echo $email_full_width; ?>" style="width:<?php echo $email_full_width; ?>px;">
						<![endif]-->
						<div style="max-width:<?php echo $email_full_width; ?>px; margin-left:auto; margin-right:auto;" align="center">												
						<table class="mainContainer" width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed; border:none; width:100%; max-width:<?php echo $email_full_width; ?>px; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" align="center">            				
            				<tr>
                				<?php if($shadow_left) echo $shadow_left; ?> 
                				<td>
									<table class="emailMainText" border="0" cellspacing="0" cellpadding="<?php echo $page_padding; ?>" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" bgcolor="<?php echo ($showcase_page_bg_color) ? $showcase_page_bg_color : $page_bg_color; ?>">
                						<?php if($showcase_title){ ?>
                						<tr>
											<td style="padding:0 <?php echo $page_padding; ?>px 0 <?php echo $page_padding; ?>px; text-align:<?php echo $text_align; ?>; font-family:'Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif; font-size:14px; line-height:normal; color:<?php echo $body_font_color; ?>;" align="<?php echo $text_align; ?>">
												<table style="border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" cellpadding="0" cellspacing="0" border="0" width="100%">
													<tr>
														<td width="2"></td>
														<td align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:16px; line-height:20px; color:<?php echo $body_heading_color; ?>; margin:0; padding:0;"><strong>
															<?php echo $showcase_title; ?>
														</strong></td>
													</tr>
													<tr style="font-size:1px; line-height:0;"><td width="2" height="3">&nbsp;</td><td height="3">&nbsp;</td></tr>
													<tr style="font-size:1px; line-height:0;"><td width="2" height="1" bgcolor="#cccccc">&nbsp;</td><td height="1" bgcolor="#cccccc">&nbsp;</td></tr>
													<tr style="font-size:1px; line-height:0;"><td width="2" height="10">&nbsp;</td><td height="10">&nbsp;</td></tr>
												</table>
											</td>
										</tr>
										<?php } ?>
                						<tr>
											<td style="padding:0 <?php echo $page_padding; ?>px 0 <?php echo $page_padding; ?>px; text-align:<?php echo $text_align; ?>; font-family:'Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif; font-size:14px; line-height:normal; color:<?php echo $body_font_color; ?>;" align="<?php echo $text_align; ?>">
												<table border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">											
													<tr>
														<td align="left">
															<?php foreach($showcase_selection as $row){ ?>
																<div style="float:left;">
																	<table class="emailShowcaseSelection" align="left" border="0" cellspacing="0" cellpadding="0" width="120" style="table-layout:fixed; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">											
																		<tr>
																			<td height="50" valign="middle" >
																				<p class="standard" align="center" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Helvetica, Arial, sans-serif; font-size:13px; font-weight:bold; line-height:14px; color:<?php echo $body_font_color; ?>; margin:0; padding:0; word-wrap:break-word;">
																					<a href="<?php echo $row['href'].'&amp;'.'utm_content=showcase'; ?>" style="color:<?php echo $body_font_color; ?>; text-decoration:none;" target="_blank" title="<?php echo $row['name']; ?>"><?php echo $row['name_short']; ?></a>
																				</p>
																			</td>
																		</tr>
																		<tr><td height="5"></td></tr>
																		<tr>
																			<td height="120" valign="top" align="center" style="text-align:center">
																				<?php if($row['thumb']): ?><a href="<?php echo $row['href'].'&amp;'.'utm_content=showcase'; ?>" title="<?php echo $row['name']; ?>">
																					<img src="<?php echo $row['thumb']; ?>" alt="" style="border:none; display:inline;" /></a>
																				<?php endif; ?>
																			</td>
																		</tr>
																	</table>
																</div>
															<?php } ?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<?php if($page_footer_text): ?>
                							<tr>
                								<td style="padding:0 <?php echo $page_padding; ?>px 0 <?php echo $page_padding; ?>px"><?php echo $page_footer_text; ?></td>
                							</tr>
										<?php endif; ?>
									</table>							
								</td>
								<?php if($shadow_right) echo $shadow_right; ?>
							</tr>							
						</table>												
						</div>
						<!--[if mso]>
								</td></tr>
							</table>
						<![endif]-->	
						</center>												 
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php endif; ?>
	<tr>
    	<td class="emailWrapper" bgcolor="<?php echo $body_bg_color; ?>" width="100%" style="width:100%; font-family:'Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif; font-size:14px; line-height:normal; color:<?php echo $body_font_color; ?>;">
	    	<table class="emailFooter" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
				<tr>
					<td width="100%" align="center" valign="top" style="text-align:center; width:100%; vertical-align:top;" bgcolor="<?php echo ($footer_section_bg_color) ? $footer_section_bg_color : $body_bg_color; ?>">
						<center>
						<!--[if mso]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo $email_full_width; ?>" style="width:<?php echo $email_full_width; ?>; border:none; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
								<tr><td width="<?php echo $email_full_width; ?>" style="width:<?php echo $email_full_width; ?>px;">
						<![endif]-->
						<div style="max-width:<?php echo $email_full_width; ?>px; margin-left:auto; margin-right:auto;" align="center">												
						<table class="mainContainer" width="100%" cellpadding="0" cellspacing="0" border="0" style="table-layout:fixed; border:none; width:100%; max-width:<?php echo $email_full_width; ?>px; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" align="center">            				
            				<tr>
                				<td width="100%" style="width:100%">                				
																		
									<?php if($shadow_bottom): ?>
                					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                						<tr>
                							<td width="<?php echo $shadow_bottom_left_img_width; ?>" height="<?php echo $shadow_bottom_left_img_height; ?>" style="width:<?php echo $shadow_bottom_left_img_width; ?>px; height:<?php echo $shadow_bottom_left_img_height; ?>px; vertical-align:top; font-size:1px; line-height:0;" valign="top">
                								<img src="<?php echo $shadow_bottom_left_img; ?>" width="<?php echo $shadow_bottom_left_img_width; ?>" height="<?php echo $shadow_bottom_left_img_height; ?>" alt="" border="0" style="outline:none; text-decoration:none; -ms-interpolation-mode:bicubic; display:inline; border:none" />
                							</td>	
                							<td valign="top" style="vertical-align:top">
                								<table class="emailShadow emailShadowBottom" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed; width:100%; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
                									<?php if($shadow_bottom_overlap): ?>
                										<tr><td height="<?php echo $shadow_bottom_overlap; ?>" bgcolor="<?php echo $page_bg_color; ?>" style="height:<?php echo $shadow_bottom_overlap; ?>px; font-size:1px; line-height:0; mso-margin-top-alt:1px">&nbsp;</td></tr>
                									<?php endif; ?>
													<?php echo $shadow_bottom; ?>
												</table>
                							</td>
                							<td width="<?php echo $shadow_bottom_right_img_width; ?>" height="<?php echo $shadow_bottom_right_img_height; ?>" style="width:<?php echo $shadow_bottom_right_img_width; ?>px; height:<?php echo $shadow_bottom_right_img_height; ?>px; vertical-align:top; font-size:1px; line-height:0;" valign="top">
                								<img src="<?php echo $shadow_bottom_right_img; ?>" width="<?php echo $shadow_bottom_right_img_width; ?>" height="<?php echo $shadow_bottom_right_img_height; ?>" alt="" border="0" style="outline:none; text-decoration:none; -ms-interpolation-mode:bicubic; display:inline; border:none" />
                							</td>
                						</tr>
									</table>								
									<?php endif; ?>
									
									<table class="emailFooterText" border="0" cellspacing="0" cellpadding="0" width="100%" height="<?php echo $footer_height; ?>" style="table-layout:fixed; width:100%; height:<?php echo $footer_height; ?>px; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">                						
                						<tr>
											<td class="legal" style="width:100%; height:<?php echo $footer_height; ?>px; font-family:'Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif; font-size:11px; line-height:normal; color:<?php echo $footer_font_color; ?>; text-align:<?php echo $footer_align; ?>; vertical-align:<?php echo $footer_valign; ?>" valign="<?php echo $footer_valign; ?> height="<?php echo $footer_height; ?>" width="100%">
												<?php if(isset($unsubscribe)): ?>
                									<p class="standard" align="<?php echo $text_align; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-size:11px; line-height:18px; color:<?php echo $footer_font_color; ?>; padding:0 0 8px 0; margin:0;">
                										<?php echo $unsubscribe; ?>
                									</p>
												<?php endif; ?>
										
												<?php echo $footer_text; ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>							
						</table>						
						</div>
						<!--[if mso]>
								</td></tr>
							</table>
						<![endif]-->
						</center>												 
					</td>
				</tr>
			</table>	    	               
        </td>
    </tr>
    <tr>
		<td height="30" style="height:30px; font-size:1px; line-height:0; mso-margin-top-alt:1px">&nbsp;</td>
	</tr>
</table>

<style type="text/css">												        				 												        				 
	/* Client-specific Styles */
	v\:* { behavior: url(#default#VML); display:inline-block} /* background image hack for outlook */
	table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }   /* table hacks mainly for outlook */
	#outlook a { padding:0 } /* Force Outlook to provide a "view in browser" button. */
	body { width:100% !important } .ReadMsgBody { width:100% } .ExternalClass { width:100% } /* Force Hotmail to display emails at full width */
	body { -webkit-text-size-adjust:none } /* Prevent Webkit platforms from changing default text sizes. */
	img { -ms-interpolation-mode: bicubic } /* Make Microsoft apps scale images properly. */
	
	.heading1 span, .heading1 span:hover, .heading1 span:active, .heading1 span:focus { color:#333333 !important; border-bottom:none !important; background:none !important; }
	.heading2 span, .heading2 span:hover, .heading2 span:active, .heading2 span:focus { color:#333333 !important; border-bottom:none !important; background:none !important; }
	.standard span, .standard span:hover, .standard span:active, .standard span:focus { color:#333333 !important; border-bottom:none !important; background:none !important; }
	.standard a:link, .standard a:visited, .standard a:hover, .standard a:active { color:#333333 }
	.link span, .link span:hover, .link span:active, .link span:focus { color:#333333 !important; border-bottom:none !important; background:none !important; text-decoration:none !important;  }
	.link a:link, .link a:visited, .link a:active { color:#28B0EC; text-decoration:none; }
	.link a:hover, .link a:focus { color:#28B0EC; text-decoration:underline !important; }
	.legal span, .legal span:hover, .legal span:active, .legal span:focus { color:#333333 !important; border-bottom:none !important; background:none !important; }
	.legal a span, .legal a span:hover, .legal a span:active, .legal a span:focus { color:#28B0EC !important; border-bottom:none !important; background:none !important; }
	.legal a:link, .legal a:visited, .legal a:active { color:#28B0EC; text-decoration:none; }
	.legal a:focus, .legal a:hover { color:#28B0EC; text-decoration:underline !important; }
	
	@media all and (max-width: <?php echo $email_full_width; ?>px) {
		img[class=emailStretch] { width:100% !important; height:auto !important; max-width:<?php echo $email_width; ?>px !important; display:block !important; }		
	}
	/* Developer: Opencart-Templates */
</style>

</body>
</html>