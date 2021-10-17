 <section class="course-details">
          <img alt="mask-group" src="<?php echo base_url()?>assets/frontend/images/mask-group.png">
         <div class="container">
            <div class="lefe-reva-content1 course-content1" data-aos="fade-up">
               <h2>NEWS</h2>
            </div>
         </div>
      </section>
      <section class="newsBanner" style="background: url(<?php echo base_url('uploads/events/banner_images/'.$get_single_news[0]['banner_images1']);?>) no-repeat;">
            <div class="container">
                  <div class="row">
                      <div class="col-md-8">
                          <div class="newsText">
                             <a href="<?php echo base_url('news/').$get_single_news[0]['slug'];?>">
                              <p><span><?=date('d', strtotime($get_single_news[0]['event_date']))?> / </span><?=date('M Y', strtotime($get_single_news[0]['event_date']))?></p>
                              <h3><?=$get_single_news[0]['title']?></h3>
                              </a>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="monthBox">
                              <ul>
                                  <li>
                                    <select name="month" id="month"class="form-control" onchange="return showData(this.value);">
                                      <option value="">Select Month</option>
                                      <option value="01">January</option>
                                      <option value="02">February</option>
                                      <option value="03">March</option>
                                      <option value="04">April</option>
                                      <option value="05">May</option>
                                      <option value="06">June</option>
                                      <option value="07">July</option>
                                      <option value="08">August</option>
                                      <option value="09">September</option>
                                      <option value="10">October</option>
                                      <option value="11">November</option>
                                      <option value="12">December</option>
                                    </select>
                                  </li>
                                  <li>
                                    <select name="year" id="year" class="form-control" onchange="return showData(this.value);">
                                      <option value="">Select Year</option>
                                      <?php for($i=date('Y');$i>=2019;$i--){?>
                                         <option value="<?=$i?>"><?=$i?></option>
                                      <?php } ?>                                      
                                    </select>
                                  </li>
                              </ul>
                              <?php foreach($get_two_news as $twoVal){?>
                              <div class="dateDetails">
                                    <a href="<?php echo base_url('news/').$twoVal['slug'];?>">
                                  <p><span><strong><?=date('d', strtotime($twoVal['event_date']))?></strong> /</span><?=date('M Y', strtotime($twoVal['event_date']))?></p>
                                  <p class="moreText"><?=$twoVal['title']?></p>
                                  </a>
                              </div>
                              <?php } ?>
                          </div>
                      </div>
                  </div>
            </div>
      </section>
      <section class="newsDetils1">
          <div class="container showEventsAanNewsClass">
              <div class="row">
                  <?php foreach($get_remaining_news as $remainingVal){?>
                  <div class="col-md-4">
                     <a href="<?php echo base_url('news/').$remainingVal['slug'];?>" class="dateDetails">
                        <p><span><strong><?=date('d', strtotime($remainingVal['event_date']))?></strong> /</span><?=date('M Y', strtotime($remainingVal['event_date']))?></p>
                        <div class="insideImage">
                            <img src="<?php echo base_url('uploads/events/'.$remainingVal['image']);?>" alt="<?=$remainingVal['title']?>">
                            <div class="insideText7">
                                <p><?=$remainingVal['title']?></p>
                            </div>
                        </div>
                    </a>
                  </div>
                  <?php } ?>                  
              </div>
              <div class="center_btn">
                  <a href="javascript:void(0);" class="btn">Load More<i class="fa fa-angle-down" aria-hidden="true"></i></a>
              </div>
          </div>
      </section>
      <script type="text/javascript">
          var site_url = '<?php echo base_url() ?>';
          function showData(str)
          {
            var month = $('#month').val();
            var year = $('#year').val();
            $.post(site_url+"News/showNews",
            {   type: 2,
                month: month,
                year: year
            },
            function(data){
               $('.showEventsAanNewsClass').html(data);
               //$('.showBox').css('display','block');
            });
          }
      </script>
  