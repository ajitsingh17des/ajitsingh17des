<!-- inner-life-reva-panel1 -->
      <section class="course-details">
          <img alt="mask-group" src="<?php echo base_url()?>assets/frontend/images/mask-group.png">
         <div class="container">
            <div class="lefe-reva-content1 course-content1" data-aos="fade-up">
               <h2>Trustees</h2>
            </div>
         </div>
      </section>
      
      <section class="trsutees_weapper">
<div class="container">
<div class="row">
<div class="col-md-5">
<div class="trustees-block">
<div class="img-panel"><img src="<?php echo base_url('uploads/trustees/'.$get_single[0]['image']); ?>"></div>
<h2><?=$get_single[0]['name']?></h2>
<p><?=$get_single[0]['designation']?></p>
</div>
</div>
<div class="col-md-7">
<div class="row">
  <?php foreach($get_trustees as $tval){?>
<div class="col-md-6">
<div class="trustees-block">
<div class="img-panel"><img src="<?php echo base_url('uploads/trustees/'.$tval['image']); ?>"></div>
<h2><?=$tval['name']?></h2>
<p><?=$tval['designation']?></p>
</div>
</div>
<?php } ?>
</div>

</div>


</div>



</div>



      </section>