<?php echo $header; ?>
<div id="content">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php echo (empty($data['FacebookLogin']['LicensedOn'])) ? base64_decode('PGRpdiBjbGFzcz0iYWxlcnQgYWxlcnQtZXJyb3IiPjxpIGNsYXNzPSJpY29uLWV4Y2xhbWF0aW9uLXNpZ24iPjwvaT4gWW91IGFyZSBydW5uaW5nIGFuIHVubGljZW5zZWQgdmVyc2lvbiBvZiB0aGlzIG1vZHVsZSEgPGEgaHJlZj0iamF2YXNjcmlwdDp2b2lkKDApIiBvbmNsaWNrPSIkKCdhW2hyZWY9I3N1cHBdJykudHJpZ2dlcignY2xpY2snKSI+Q2xpY2sgaGVyZSB0byBlbnRlciB5b3VyIGxpY2Vuc2UgY29kZTwvYT4gdG8gZW5zdXJlIHByb3BlciBmdW5jdGlvbmluZywgYWNjZXNzIHRvIHN1cHBvcnQgYW5kIHVwZGF0ZXMuPC9kaXY+') : '' ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-error"><i class="icon-exclamation-sign"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if (!empty($success_message)) { ?>
    <div class="alert alert-success autoSlideUp"><i class="icon-ok-sign"></i> <?php echo $success_message; ?></div>
    <script> $('.autoSlideUp').delay(3000).fadeOut(600, function(){ $(this).show().css({'visibility':'hidden'}); }).slideUp(600);</script>
    <?php $success_message = null; } ?>
  <div class="box">
  	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="navbar">
      <div class="navbar-inner"><a class="brand"><i class="icon-pencil"></i><?php echo $heading_title; ?></a> 
      
      <ul class="nav nav-tabs mainMenuTabs">
			<?php foreach($tabs as $index => $tab): ?>
            <li<?php echo $index == 0 ? ' class="active"' : ''; ?>><a href="#tab_<?php echo $index; ?>" data-toggle="tab" data-tofbke="tab"><?php echo $tab['name']; ?></a></li>
            <?php endforeach; ?>
        </ul>
      
      <div class="buttons"><button type="submit" class="btn btn-success save-changes"><i class="icon-ok icon-white"></i> <?php echo $button_save; ?></button> <a href="<?php echo $cancel; ?>" class="btn btn-danger"><i class="icon-remove icon-white"></i> <?php echo $button_cancel; ?></a></div></div>
    </div>
    <div class="box-content">
        <div class="tab-content">
        	<?php foreach($tabs as $index => $tab): ?>
            <div class="row-fluid tab-pane <?php echo $index == 0 ? 'active' : ''; ?>" id="tab_<?php echo $index; ?>">
                <?php require_once($tab['file']); ?>
            </div>
			<?php endforeach; ?>
        </div>
    </div>
    <input type="hidden" name="FacebookLogin[Activated]" value="Yes" />
    <input type="hidden" class="selectedTab" name="selectedTab" value="<?php echo (empty($this->request->get['tab'])) ? 0 : $this->request->get['tab'] ?>" />
    <input type="hidden" class="selectedStore" name="selectedStore" value="<?php echo (empty($this->request->get['store'])) ? 0 : $this->request->get['store'] ?>" />
    </form>
  </div>
</div>
<script>
if (window.localStorage && window.localStorage['currentTab']) {
	$('.mainMenuTabs a[href='+window.localStorage['currentTab']+']').trigger('click');  
}
if (window.localStorage && window.localStorage['currentSubTab']) {
	$('a[href='+window.localStorage['currentSubTab']+']').trigger('click');  
}
$('.fadeInOnLoad').css('visibility','visible');
$('.mainMenuTabs a[data-toggle="tab"]').click(function() {
	if (window.localStorage) {
		window.localStorage['currentTab'] = $(this).attr('href');
	}
});
$('a[data-toggle="tab"]:not(.mainMenuTabs a[data-toggle="tab"])').click(function() {
	if (window.localStorage) {
		window.localStorage['currentSubTab'] = $(this).attr('href');
	}
});
</script>
<?php echo $footer; ?>