
<!-- about-panel1 -->
<?php if(isset($pageData['section1']) && $pageData['section1']!=''){?>
<section class="about-panel1" style="background: url(<?php echo base_url('uploads/cms_images/'.$pageData['image1']);?>) no-repeat;">
  <div class="path-3"><img src="<?php echo base_url()?>assets/frontend/images/logo-icon.svg" class="img-fluid"></div>
<div class="container">
<div class="about-panel-content1" data-aos="fade-up">
  <h2>ABOUT US</h2>
  <div class="about-box1">
<?=$pageData['section1']?>
<div class="read-more"><a href="#" onclick="return false;"><i class="fa fa-angle-right" aria-hidden="true"></i></a></div>
  </div>


</div>


</div>



</section>
<?php }if(isset($pageData['section2']) && $pageData['section2']!=''){ ?>

<!-- about-panel2 -->

<section class="about-panel2" style="background: url(<?php echo base_url('uploads/cms_images/'.$pageData['image2']);?>) no-repeat;">
  <div class="container">

<div class="about-panel-content2"data-aos="fade-up" data-aos-anchor-placement="top-center">
<?=$pageData['section2']?>
<div class="read-more"><a href="#" onclick="return false;"><i class="fa fa-angle-right" aria-hidden="true"></i></a></div>


</div>


  </div>
</section>
<?php }if(isset($pageData['section3']) && $pageData['section3']!=''){ ?>

<!-- about-panel3 -->

<section class="about-panel3" style="background: url(<?php echo base_url('uploads/cms_images/'.$pageData['image3']);?>) no-repeat;">
    <div class="container">
  
  <div class="about-panel-content3" data-aos="fade-up">
  <?=$pageData['section3']?>
  <div class="read-more"><a href="#" onclick="return false;"><i class="fa fa-angle-right" aria-hidden="true"></i></a></div>
  
  
  </div>
  
  
    </div>
  </section>
  
<?php }if(isset($pageData['section4']) && $pageData['section4']!=''){ ?>


<!-- about-panel4 -->

<section class="about-panel4" style="background: url(<?php echo base_url('uploads/cms_images/'.$pageData['image4']);?>) no-repeat;">
    <div class="container">
  
  <div class="about-panel-content4" data-aos="fade-up">
  <?=$pageData['section4']?>
  <div class="read-more"><a href="#" onclick="return false;"><i class="fa fa-angle-right" aria-hidden="true"></i></a></div>
  
  
  </div>
  
  
    </div>
  </section>
<?php } ?>
