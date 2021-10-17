<section class="course-details">
          <img alt="mask-group" src="<?php echo base_url()?>assets/frontend/images/mask-group.png">
         <div class="container">
            <div class="lefe-reva-content1 course-content1" data-aos="fade-up">
               <h2>IQAC Policies</h2>
            </div>
         </div>
      </section>
      
      <section class="trust_wrapper iq-policiees">
<div class="container">

   <div class="about_txt">
    <?php foreach($get_iqac_meeting_proceedings as $impVal){?>
      <p><a class="primary-button" href="<?php echo base_url('uploads/pdf/'.$impVal['upload_pdf']);?>" target="blank"><?=$impVal['title']?></a></p>
    <?php } ?>
<div class="container">
 <div class="gallery-carousel popup-gallery owl-carousel owl-theme owl-loaded">
     
     
   

 <div class="owl-stage-outer"><div class="owl-stage"></div></div></div>
</div>
</div>

</div>



      </section>