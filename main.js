$(document).ready(function(){
    fetch_posts();

    // Form submit handler
    $('#post-form').on('submit', function(e) {
        e.preventDefault(); 

        var postContent = $('#post-content').val().trim();
        if(postContent === '') return; // ignore empty

        $.ajax({
            url: 'insert_post.php',
            type: 'POST',
            dataType: 'json',
            data: { post_content: postContent },
            success: function(response) {
                if(response.status === "success"){
                    $('#form-message')
                        .stop(true, true)
                        .hide()
                        .html(`<div class="alert alert-success">${response.message}</div>`)
                        .fadeIn(300)
                        .delay(2000)
                        .fadeOut(500);
                    $('#post-content').val(''); // clear textarea
                    fetch_posts(); // refresh post feed
                } else {
                    $('#form-message')
                        .stop(true, true)
                        .hide()
                        .html(`<div class="alert alert-success">${response.message}</div>`)
                        .fadeIn(300)
                        .delay(2000)
                        .fadeOut(500);
                }
            },
            error: function() {
                 $('#form-message')
                        .stop(true, true)
                        .hide()
                        .html(`<div class="alert alert-success">Error posting please try again</div>`)
                        .fadeIn(300)
                        .delay(2000)
                        .fadeOut(500);
            }
        });
    });

    // Fetch all posts
    function fetch_posts(){
        $.ajax({
            url: 'fetch_post.php',
            type: 'GET',
            success: function(data){
                $('#post-container').html(data);
            }
        });
    }

    $('#profile-toggle').on('click',(e)=>{
      e.stopPropagation();
      $('#profile-popup').toggle();
    })

    $(document).on('click',()=>{
      $('#profile-popup').hide();
    })

    var profileModal = new bootstrap.Modal(document.getElementById('profileModal'));

    // Open modal and fetch user data
    $('#user-info').on('click', function(){
        profileModal.show();

        $.ajax({
            url: 'fetch_user.php',
            type: 'GET',
            dataType: 'json',
            success: function(res){
                if(res.status === 'success'){
                    var data = res.data;
                    $('#profile-form [name="Name"]').val(data.Name);
                    $('#profile-form [name="Email_id"]').val(data.Email_id);
                    $('#profile-form [name="Address"]').val(data.Address);
                    $('#profile-form [name="Phone"]').val(data.Phone);
                } else {
                    $('#form-message').html('<p class="text-danger">'+res.message+'</p>');
                }
            },
            error: function(){
                $('#form-message').html('<p class="text-danger">Error loading profile.</p>');
            }
        });
    });

    // Handle profile update
    $('#profile-form').on('submit', function(e){
        e.preventDefault();
       
        $.ajax({
            url: 'update_user.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res){
                if(res.status === 'success'){
                      $('#form-message')
                        .stop(true, true)
                        .hide()
                        .html(`<div class="alert alert-success">${res.message}</div>`)
                        .fadeIn(300)
                        .delay(2000)
                        .fadeOut(500);
                        fetch_posts();
                } else {
                    $('#form-message')
                        .stop(true, true)
                        .hide()
                        .html(`<div class="alert alert-danger">${res.message}</div>`)
                        .fadeIn(300)
                        .delay(2000)
                        .fadeOut(500);
                }
            },
            error: function(){
                $('#form-message').html('<p class="text-danger">Error updating profile.</p>');
            }
        });
    });

    $('#cancel-btn').on('click',()=>{
      profileModal.hide();
    })
    // Logout
    $('#logout-btn').on('click', function(){
        $.ajax({
            url: 'logout.php',
            type: 'POST',
            success: function(){
                window.location.href = 'index.php';
            },
            error: function(){
                alert('Error logging out.');
            }
        });
    });

  $.ajax({
        url: 'fetch_friend.php',   // your PHP file
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            const friendList = $('#friend-list');
            friendList.empty(); // clear existing content

            if (response.status === 'success' && response.friends.length > 0) {
                $('#friends-count').text(response.total_friends+' Friends')
                response.friends.forEach(friend => {
                    friendList.append(`
                        <div class="d-inline-block text-center me-3">
                            <img src="${friend.Image || 'img/default-user.png'}" 
                                alt="${friend.Name}" 
                                class="rounded-circle mb-2 friend-images-content" >
                            <h6 class="mb-0">${friend.Name}</h6>
                        </div>
                    `);
                });
            } else {
                friendList.html('<p class="text-muted">No friends found.</p>');
            }
        },
        error: function() {
            $('#friend-list').html('<p class="text-danger">Error loading friends.</p>');
        }
    });
});
