
<section class="course-details">
          <img alt="mask-group" src="<?php echo base_url()?>assets/frontend/images/mask-group.png">
         <div class="container">
            <div class="lefe-reva-content1 course-content1" data-aos="fade-up">
               <h2><?=ucfirst($ptitle)?></h2>
            </div>
         </div>
      </section>
      <section class="newsBannerDetails">
            <div class="container">
                <div class="head_section">
                  <div class="row">
                      <div class="col-md-9">
                              <p><?=date('d M Y', strtotime($get_single_events['event_date']))?></p>
                              <h3><?=$get_single_events['title']?></h3>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo base_url().$ptitle;?>" class="btn backBtn pull-right"><i class="fa fa-angle-left" aria-hidden="true"></i>Back</a>
                        </div>
                  </div>
                </div>
                <?=$get_single_events['description']?>
                <!--<div class="founder events_details">
                    <div class="row">
                      <div class="col-md-6 pr-0">
                          <div class="fondImage">
                              <img src="<?php //echo base_url('uploads/events/'.$get_single_events['image']);?>" alt="found-img">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="fondText8">
                              <p><strong>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.</strong></p>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="fondText9">
                              <p>
                                In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. </p><p>Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc.
                              </p>
                          </div>
                      </div>
                      <div class="col-md-6 pl-0">
                          <div class="fondImage fourImg">
                              <ul>
                                  <li><img src="<?php //echo base_url()?>assets/frontend/images/events-20.jpg"></li>
                                  <li><img src="<?php //echo base_url()?>assets/frontend/images/events-21.jpg"></li>
                                  <li><img src="<?php //echo base_url()?>assets/frontend/images/events-20.jpg"></li>
                                  <li><img src="<?php //echo base_url()?>assets/frontend/images/events-21.jpg"></li>
                              </ul>
                          </div>
                      </div>
                    </div>
                    <div class="socialIcons7">
                        <ul>
                            <li><a href="javascript:void(0);"><i class="fa fa-print" aria-hidden="true"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-share-alt" aria-hidden="true"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-file-pdf" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
                -->
            </div>
      </section>