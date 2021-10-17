<!-- inner-life-reva-panel1 -->
      <section class="course-details">
          <img alt="mask-group" src="<?php echo base_url()?>assets/frontend/images/mask-group.png">
         <div class="container">
            <div class="lefe-reva-content1 course-content1" data-aos="fade-up">
               <h2> NIRF </h2>
            </div>
         </div>
      </section>
      
      <section class="trust_wrapper place-ment">
<div class="container">
   <div class="about_txt1">
         <div class="border1">
   <h1>NIRF 2021</h1>
 <ul>
    <?php foreach($get_nirf as $nVal){?>
     <li><a class="primary-button" href="<?=$nVal['other_page_url']?>" target="_blank"> <?=$nVal['title']?></a></li>
    <?php } ?>      
               
               </ul>
          </div>

   </div>


</div>






      </section>