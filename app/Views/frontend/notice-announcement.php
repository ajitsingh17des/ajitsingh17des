    <section class="course-details noticePage">
          <img alt="mask-group" src="<?php echo base_url()?>assets/frontend/images/mask-group.png">
         <div class="container">
            <div class="lefe-reva-content1 course-content1" data-aos="fade-up">
               <h2>NOTICES & ANNOUNCEMENTS</h2>
            </div>
         </div>
      </section>
      <section class="notice_details">

  <div class="container cardMateri">
    <div class="paddingLuar">

      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">          
          <?php $i=1; foreach($get_notices_and_announcements as $fVal){ ?>
          <div class="panel panel-default <?php if($i%2==0){echo 'grey9';}?>">
              <div class="panel-heading" role="tab" id="heading<?=$i?>">
                  <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$i?>" aria-expanded="false" aria-controls="collapse<?=$i?>">
                        <div class="dateDetails">
                              <p><span><strong><?=date('d', strtotime($fVal['created_date']))?></strong> /</span><?=date('M Y', strtotime($fVal['created_date']))?></p>
                          </div><?=$fVal['title']?>
                      </a>
                  </h4>
              </div>
              <div id="collapse<?=$i?>" class="panel-collapse collapse" role="tabpanel" data-parent="#accordion" aria-labelledby="heading<?=$i?>">
                  <div class="panel-body">
                      <div class="isiMateri">
                          <?=$fVal['description']?>
                      </div>
                  </div>
              </div>
          </div>
       <?php $i++;} ?> 
       <span class="pagination_loader"></span>       
      </div>
  </div>
  <?php if(count($get_notices_and_announcements)>=$limit){ ?>
  <div class="center_btn">
      <a href="javascript:void(0);" id="loadMore1" class="btn loadMore_fac">Load More<i class="fa fa-angle-down" aria-hidden="true"></i></a>
   </div>
<?php } ?>
</div>
      </section>