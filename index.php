<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Gap Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
  </head>
  <body>
   
    <!-- ##########################################################
                                 TOPBAR
     ############################################################## -->

    <div class="row border-bottom g-0 top-bar px-3 position-sticky top-0 topbar">
      <div class="col-sm-1 col-xl-3 col-2 top-bar-logo-container">
        <div class="d-flex align-items-center gap-1 h-100 py-1">
          <img src="img//facebook-logo.svg" alt="" class="facebook-logo">
      
          <div class="text-start d-flex search-bar-container my-auto">
            <span>
              <img src="img/search-bar.svg" alt="" class="search-icon">
            </span>
            <input type="text" class="search-bar-input d-none d-xl-inline" placeholder="Search Facebook">
          </div>
        </div>
      </div>

      <!-- NAV ICONS -->
      <div class="col-sm-7 col-xl-7 d-none d-sm-inline  topbar-nav">
        <div class="d-flex h-100 topbar-nav-container">
            <button class="topbar-nav-icons btn h-100"><img src="img//home.svg" class="svg-icon-image" alt="">  </button>
            <button class="topbar-nav-icons btn h-100"><img src="img/video.svg" class="svg-icon-image" alt="">  </button>
            <button class="topbar-nav-icons btn h-100"><img src="img/video2.svg"class="svg-icon-image"  alt=""> </button>
            <button class="topbar-nav-icons btn h-100"><img src="img/group.svg" class="svg-icon-image" alt="">  </button>
            <button class="topbar-nav-icons btn h-100"><img src="img/gaming.svg"class="svg-icon-image"  alt=""> </button>
        </div>
      </div>

      <!-- TOPBAR PROFILE SECTION -->
      <div class="col-sm-3 col-xl-2 col-7 ms-auto top-bar-profile-container">
        <div class="d-flex gap-2 h-100 py-2 justify-content-end pe-2">
          <div class="rounded-circle topbar-svg-container p-xl-3"><img src="img/menu.svg" alt="" class="top-bar-profile-svg-image"></div>
          <div class="rounded-circle topbar-svg-container">
            <img src="img/messenger.svg" alt="" class="top-bar-profile-svg-image">
            <span class="notification-numbers">1</span>
          </div>
          <div class="rounded-circle topbar-svg-container">
            <img src="img/notification.svg" alt="" class="top-bar-profile-svg-image">
            <span class="notification-numbers">2</span>
          </div>
          <div class="rounded-circle topbar-svg-container" id="profile-toggle">
            <div class="overflow-hidden rounded-circle">
              <img src="img/profilepic.jpg" alt="" width="100%" height="100%">
            </div>
            <div class="profile-down-arrow">
              <img src="img/down-arrow.svg" alt="">
            </div>
          </div>
        </div>  
      </div>
    </div>
    <div class="shadow-sm" id="profile-popup">
      <div id="user-info" class="d-flex gap-3 align-items-center">
        <img src="img/profilepic.jpg" alt="" height="40px" width="40px" class="rounded-circle">
        <span class="popup-profile-name">Profile Info</span>
      </div>
      <hr>
      <button class="btn btn-outline-danger btn-sm" id="logout-btn">Logout</button>
    </div>


    <div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="profile-form">
              <div id="form-message"></div>
              <div class="mb-2">
                <label>Name :</label>
                <input type="text" name="Name" class="form-control mt-2" required>
              </div>
              <div class="mb-2">
                <label>Email :</label>
                <input type="email" name="Email_id" class="form-control mt-2" required>
              </div>
              <div class="mb-2">
                <label>Address :</label>
                <input type="text" name="Address" class="form-control mt-2">
              </div>
              <div class="mb-2">
                <label>Phone :</label>
                <input type="text" name="Phone" class="form-control mt-2">
              </div>
              <button type="submit" class="btn btn-success w-100 mt-2">Save</button>
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-outline-danger w-100" id="cancel-btn">Cancel</button>
          </div>
        </div>
      </div>
    </div>


 
    <!-- ###############################################
                      PROFILE BANNER
     ################################################### -->
      <div class="row g-0 profile-banner-container cover-img-row">
        <div class="col-12 col-xl-11 col-xxl-8 p-0 mx-auto px-xl-2 profile-banner-container">
          <div class="profile-banner border-bottom rounded overflow-hidden">
              <img src="img/cover-img.jpg" alt="" width="100%" class="banner-image">
          </div>
        </div>
      </div>
      <div class="row g-0 profile-banner-container">
        <div class="col-xl-11 col-xxl-8  col-12 p-0 mx-auto">
        <div class="px-3">
           <div class="row g-0 profile-summary">
               <div class="col-lg-2 col-12 profile-summary-image">
                <div class="rounded-circle overflow-hidden dp-image-container text-center mx-auto mx-xl-0">
                  <img src="img/mark-zuckerberg.jpg" alt="" class="dp-image">
                </div>
               </div>
               <div class="col-lg-6 col-12">
                <div class="h-100">
                  <div class="d-flex flex-column justify-content-end  summary-detail-container ">
                    <h3 class="username text-center text-lg-start mt-2 mt-xl-0">Mark Zuckerberg <span><img src="img//verified-account.svg" alt=""></span></h3>
                    <span class="followers-count text-center text-lg-start">120M followers</span>
                    <div class="friends-images-container text-center text-lg-start">
                      <img class="rounded-circle " src="img/556782636_818411404200192_1331317563930606073_n.jpg" alt="">
                      <img class="rounded-circle friends-images" src="img/557626704_122093789451062013_8917716199390515086_n.jpg" alt="">
                      <img class="rounded-circle friends-images" src="img/453178253_471506465671661_2781666950760530985_n.png" alt="">
                      <img class="rounded-circle friends-images" src="img/557636813_122140162322842339_3905535091988749455_n.jpg" alt="">
                      <img class="rounded-circle friends-images" src="img/524052200_674941578919745_8517345223330661836_n.jpg" alt="">
                      <img class="rounded-circle friends-images" src="img/557272656_1198085652339739_5862852740293634618_n.jpg" alt="">
                      <img class="rounded-circle friends-images" src="img/528309596_737690272408790_5441655425958050033_n.jpg" alt="">
                      <img class="rounded-circle friends-images" src="img/558976479_122158606838832718_7043298310156851168_n.jpg" alt="">
                    </div>
                  </div>
                </div>
               </div>
               <div class="col-lg-4 col-xl-3 col-12 mb-2">
                <div class="d-flex align-items-end h-100 justify-content-lg-end justify-content-center mt-xl-3 mt-2 mt-xl-0 pb-2">
                  <div class="d-flex gap-2 mt-auto summary-actions">
                    <button class="follow-buttton d-flex align-items-center gap-2"><img src="img/follow-icon.png" alt="" class="follow-icon">Follow</button>
                    <button class="d-flex align-items-center gap-2 profile-summary-search"><img src="img/summary-search.svg" alt="">Search</button>
                    <button class=" profile-summary-dropdown"><img src="img/dropdown.svg" alt=""></button>
                  </div>
                </div>
               </div>
           </div>
           <hr class="horizontal-line mx-auto">
           <div class="row g-0">
               <div class="col-xl-10 col-10 nav-tabs-container">
                   <div class="d-flex h-100 py-1">
                       <div class="px-3 h-100 d-flex align-items-center profile-nav-tabs active"><span >Posts</span></div>
                       <div class="px-3 h-100 d-flex align-items-center profile-nav-tabs"><span >About</span></div>
                       <div class="px-3 h-100 d-flex align-items-center profile-nav-tabs"><span >Channels</span></div>
                       <div class="px-3 h-100 d-flex align-items-center profile-nav-tabs d-none d-sm-flex"><span >Reels</span></div>
                       <div class="px-3 h-100 align-items-center d-none profile-nav-tabs d-sm-flex"><span>Photos</span></div>
                       <div class="px-3 h-100 align-items-center d-none profile-nav-tabs d-sm-flex"><span>Events</span></div>
                       <div class="px-3 h-100 align-items-center d-none profile-nav-tabs d-sm-flex"><span>More <img src="img/more-down-arrow.svg" alt=""></span></div>
                   </div>
               </div>
               <div class="col-xl-1 col-2 ms-xl-5 my-auto ps-4 ps-xl-0">
                <div class="d-flex justify-content-end">
                  <div class="doted-button px-3">
                    <img src="img/3-dots.svg" alt="">
                  </div>
                </div>
               </div>
           </div>
          
        </div>  
        </div>
        <div class=" profile-post-content row g-0">
          <div class="mt-3 col-xxl-8  col-12 col-xl-11 px-4 px-xl-0 mx-auto">
                <div class="row g-4 post-container-footer">
                    <div class="col-lg-5 col-12 p-0">
                      <div class="w-100 profile-details-card p-3">
                        <h5 class="intro-heading">Intro</h5>
                        <div class="text-center">Bringing the world closer together.</div>
                        <hr>
                        <div class="d-flex gap-3">
                          <img src="img/important.png" alt="">
                          <strong>Profile </strong><span>public figure</span>
                        </div>
                        <div class="d-flex gap-3 mt-3">
                          <img src="img/work.png" alt="">
                          <span>Founder and CEO at <strong>Meta</strong></span>
                        </div>
                        <div class="d-flex gap-3 mt-3">
                          <img src="img/work.png" alt="">
                          <span>Works at<strong> Chan Zuckerberg Initiative</strong></span>
                        </div>
                        <div class="d-flex gap-3 mt-3">
                          <img src="img/graduate.png" alt="">
                          <span>Studied Computer Science and Psychology at<strong> Harvard University</strong></span>
                        </div>
                        <div class="d-flex gap-3 mt-3">
                          <img src="img/place-icon.png" alt="">
                          <span>Lives in<strong> Palo Alto, California</strong></span>
                        </div>
                        <div class="d-flex gap-3 mt-3">
                          <img src="img/location.png" alt="">
                          <span>From <strong>Dobbs Ferry, New York</strong></span>
                        </div>
                        <div class="d-flex gap-3 mt-3">
                          <img src="img/heart.png" alt="">
                          <span>Married<strong> to Priscilla Chan</strong></span>
                        </div>
                        <div class="d-flex gap-3 mt-3">
                          <img src="img/channel.png" alt="">
                          <span>Meta Channel</span>
                          <br>
                        </div>
                      </div>
                      <div class="w-100 mt-3 bg-white p-3">
                        <h5 class="text-center">Friend List</h5>
                        <div id="friend-list"></div>
                      </div>
                    </div>
                    <div class="col-lg-7 col-12 pe-0 ps-xl-3 ps-0">
                        <div class="w-100 d-flex justify-content-between post-heading-card py-2 px-3">
                          <h5 class="my-auto post-card-heading">Posts</h5>
                          <button class="filter-button px-2 d-flex gap-2 align-items-center">
                            <img src="img/filter.svg" alt="" width="20px" height="20px">
                            Filters</button>
                        </div>
                       <div class="w-100 bg-white p-3 mt-3 post-form-container">
                          <form id="post-form">
                              <textarea name="post_content" id="post-content" class="form-control mt-2" placeholder="Write something to post...!" rows="3" required></textarea>
                              <div class="d-flex justify-content-end">
                                  <button type="buttton" class="btn btn-primary mt-2" name="submit_post" id="post-btn">Post</button>
                              </div>  
                          </form>
                          <div id="message" class=""></div>

                      </div>
                        <div id="post-container" class="w-100"></div>
                    </div>
                </div>
          </div>
        </div>
      </div>
     </div>
    </div>
  </body>
</html>
