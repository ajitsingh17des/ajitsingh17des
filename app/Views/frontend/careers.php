<section class="inner-head-panel">
    <div class="path-3"><img src="<?php echo base_url()?>assets/frontend/images/logo-icon.svg" class="img-fluid"></div>
<div class="container">
<h1><?=$pageData['page_name']?></h1>
</div>
</section>
<section class="career-panel1">
<div class="container">
<div class="row">
<div class="col-md-4">
<h3><?=$pageData['heading']?></h3>
</div>
<div class="col-md-8"><img src="<?php echo base_url('uploads/cms_images/'.$pageData['image1'])?>" class="img-fluid"></div>
</div>
</div>
</section>
<section class="career-panel2">
<div class="container">
<?=$pageData['section1']?>
<h6>Please send your resume to <a href="mailto:careers@reva.edu">careers@reva.edu </a>  in to find your ideal career at REVA. Lets grow from strength to strength, together!</h6>
<div class="contact-hr">
<h4>Contact HR Team</h4>
<div class="contact-phone">Phone: <a href="tel:91-80-46966966">+91-80-46966966</a></div>
<div class="contact-email">Email:  <a href="mailto:hrteam@reva.edu.in">hrteam@reva.edu.in</a></div>
<div class="doen-resume"><a href="">DOWNLOAD RESUME FORMAT <img src="<?php echo base_url()?>assets/frontend/images/excel-icon.png"></a></div>
</div>
</div>
</section>
<section class="career-testimonial">
<div class="container">
<div class="owl-carousel career-testimonial-slider owl-theme">
  <?php foreach($get_testimonial as $testimonialVal){?>
<div class="item">
<div class="row">
  <div class="col-md-4">
<div class="areer-testi-img">
  <img src="<?php echo base_url('uploads/testimonial/'.$testimonialVal['image'])?>" class="img-fluid">
</div>
  </div>
  <div class="col-md-8">
<div class="career-test-detail">
<h2><?=$testimonialVal['name']?></h2>
<h6><?=$testimonialVal['designation']?></h6>
<h4><?=$testimonialVal['organization']?></h4>
 <p><?=$testimonialVal['description']?></p>
</div>
</div>
</div>
</div>
<?php } ?>
</div>
</div>
</section>
<section class="career-current-opening">
<div class="container">
<h2>Current Openings</h2>
<div class="row">
<?php foreach($openingData as $openingVal){?>
<div class="col-md-4">
  <div class="carer_wrappper">
<div class="career-opening">
<h3><?=$openingVal['title']?></h3>
<div class="years-current"><img src="<?php echo base_url()?>assets/frontend/images/year-img.jpg"> <?=$openingVal['year']?></div>
<div class="place-current"><img src="<?php echo base_url()?>assets/frontend/images/place-img.jpg"> <?=get_city_name($openingVal['city_id'])?>, <?=get_state_name($openingVal['state_id'])?></div>
</div>
<div class="career-apply">
<div class="apply-now"><a href="">Apply Now</a></div>
<div class="read-more"><a href=""><i class="fa fa-angle-right" aria-hidden="true"></i></a></div>
</div>
</div>
</div>
<?php } ?>
<div class="col-md-12">  <a href="#" id="loadMore">Load More <i class="fa fa-angle-down" aria-hidden="true"></i></a></div>
</div>
</div>
</section>