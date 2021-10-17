<!-- inner-life-reva-panel1 -->
      <section class="course-details">
          <img alt="mask-group" src="<?php echo base_url()?>assets/frontend/images/mask-group.png">
         <div class="container">
            <div class="lefe-reva-content1 course-content1" data-aos="fade-up">
               <h2>TESTIMONIALS</h2>
            </div>
         </div>
      </section>

      <section class="testimonialsPage">
          <div class="container">
            <section class="tab_accordian">
              <ul class="nav nav-tabs responsive-tabs">
                <li class="active"><a href="#Student">Student</a></li>
                <li><a href="#Parents">Parents</a></li>
                <li><a href="#Alumni">Alumni</a></li>
                <li><a href="#Faculty">Faculty</a></li>
              </ul>

       <div class="tab-content">
        <div class="tab-pane active" id="Student">
            <div class="testimonialsBox">

                <div class="row">
                <?php if(count($get_testimonials_student)>0){foreach($get_testimonials_student as $tsVal){?>
                <div class="col-md-6">
                    <div rel="<?php echo $tsVal['id']; ?>" class="testimonialsMainBox" data-toggle="modal" data-target="#client1">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="testmoilasImg">
                                    <img src="<?php echo base_url('uploads/testimonial/'.$tsVal['image']);?>" alt="<?=$tsVal['name']?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="testmoilasText">
                                  <p class="computer7"><strong><?=$tsVal['description']?></strong></p>
                                  <div class="clients_name">
                                    <h5><?=$tsVal['name']?></h5>
                                    <?=$tsVal['designation']?>
                                  </div></div>
                            </div>
                          </div>
                    </div>
                  </div>
                <?php }}else{echo '<div class="col-md-12" style="color:red;">Data not found!</div>';} ?>              
                </div>
            </div>
        </div>

        <div class="tab-pane" id="Parents">
          <div class="testimonialsBox">
              <div class="row">
                <?php if(count($get_testimonials_parents)>0){foreach($get_testimonials_parents as $tpVal){?>
                <div class="col-md-6">
                    <div rel="<?php echo $tpVal['id']; ?>" class="testimonialsMainBox" data-toggle="modal" data-target="#client1">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="testmoilasImg">
                                    <img src="<?php echo base_url('uploads/testimonial/'.$tpVal['image']);?>" alt="<?=$tpVal['name']?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="testmoilasText">
                                  <p class="computer7"><strong><?=$tpVal['description']?></strong></p>
                                  <div class="clients_name">
                                    <h5><?=$tpVal['name']?></h5>
                                    <?=$tpVal['designation']?>
                                  </div></div>
                            </div>
                          </div>
                    </div>
                  </div>
                <?php }}else{echo '<div class="col-md-12" style="color:red;">Data not found!</div>';} ?>
        </div>
        </div>
        </div>

        <div class="tab-pane" id="Alumni">
          <div class="testimonialsBox">

              <div class="row">
                <?php if(count($get_testimonials_alumni)>0){foreach($get_testimonials_alumni as $taVal){?>
                <div class="col-md-6">
                    <div rel="<?php echo $taVal['id']; ?>" class="testimonialsMainBox" data-toggle="modal" data-target="#client1">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="testmoilasImg">
                                    <img src="<?php echo base_url('uploads/testimonial/'.$taVal['image']);?>" alt="<?=$taVal['name']?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="testmoilasText">
                                  <p class="computer7"><strong><?=$taVal['description']?></strong></p>
                                  <div class="clients_name">
                                    <h5><?=$taVal['name']?></h5>
                                    <?=$taVal['designation']?>
                                  </div></div>
                            </div>
                          </div>
                    </div>
                  </div>
                <?php }}else{echo '<div class="col-md-12" style="color:red;">Data not found!</div>';} ?> 
                </div>
                </div>
        </div>

        <div class="tab-pane" id="Faculty">
          <div class="testimonialsBox">

              <div class="row">
                <?php if(count($get_testimonials_faculty)>0){foreach($get_testimonials_faculty as $tfVal){?>
                <div class="col-md-6">
                    <div rel="<?php echo $tfVal['id']; ?>" class="testimonialsMainBox" data-toggle="modal" data-target="#client1">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="testmoilasImg">
                                    <img src="<?php echo base_url('uploads/testimonial/'.$tfVal['image']);?>" alt="<?=$tfVal['name']?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="testmoilasText">
                                  <p class="computer7"><strong><?=$tfVal['description']?></strong></p>
                                  <div class="clients_name">
                                    <h5><?=$tfVal['name']?></h5>
                                    <?=$tfVal['designation']?>
                                  </div></div>
                            </div>
                          </div>
                    </div>
                  </div>
                  <spsn class="load-more"></spsn>
                <?php }}else{echo '<div class="col-md-12" style="color:red;">Data not found!</div>';} ?>
                
                </div>
                </div>
       </div>


            </section>
            <div class="center_btn">
              <button type="button" class="btn" onclick="loadmore('Student')">Load More<i class="fa fa-angle-down" aria-hidden="true"></i></button>
              <input type="hidden" name="limit" id="limit" value="10"/>
              <input type="hidden" name="offset" id="offset" value="20"/>
            </div>
            <!--<div class="center_btn">
                  <a href="javascript:void(0);" class="btn" onclick="loadmore('Student');">Load More<i class="fa fa-angle-down" aria-hidden="true"></i></a>
              </div>
            -->
          </div>

      </section>
<script src="<?php echo base_url()?>assets/frontend/js/jquery.min.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
 var site_url = '<?php echo base_url() ?>';
 $('.testimonialsMainBox').bind('click',function(){
  var id = $(this).attr('rel');
  $.post(site_url+"Testimonials/showTestimonial",{ id: id },
  function(data){
    $('.showEventsAanNewsClass').html(data);      
  });
 })
})
</script>

<div class="modal fade" id="client1" tabindex="-1" role="dialog" aria-labelledby="client1Label" aria-hidden="true">
    <div class="modal-dialog  center-block" role="document">
      <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        <div class="modal-body showEventsAanNewsClass"></div>

      </div>
    </div>
  </div>

<script type="text/javascript">
  var site_url = '<?php echo base_url() ?>';
  function loadmore(str)
  {
    var offset = $('#offset').val();
    var limit = $('#limit').val();
    $.post(site_url+"Testimonials/loadmore",
    {   offset: offset,
        limit: limit,
        type: str
    },
    function(data){alert(data);
       //$('.showEventsAanNewsClass').html(data);
       //$('.load-more').prepend(data.view);
       //$('#offset').val(data.offset);
       //$('#limit').val(data.limit);
    });
  }  
</script>