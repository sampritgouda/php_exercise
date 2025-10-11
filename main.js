$(document).ready(function(){
    const urlParams = new URLSearchParams(window.location.search);
    const userId = urlParams.get('user_id');
    fetch_posts();
    fetch_name();

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
                    showMessage('success', response.message);
                    $('#post-content').val(''); // clear textarea
                    fetch_posts(); // refresh post feed
                } else {
                     showMessage('warning', response.message);
                }
            },
            error: function() {
                showMessage('error', 'Error posting please try again');
            }
        });
    });

    // Fetch all posts
    function fetch_posts(){
        $.ajax({
            url: 'fetch_post.php',
            type: 'GET',
            data: { user_id: userId },
            success: function(data){
                $('#post-container').html(data);
            }
        });
    }

    //open profile popup
    $('#profile-toggle').on('click', function(e) {
    e.stopPropagation();

    // Check if user is logged in
    $.ajax({
        url: 'check_session.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
        if (!response.logged_in) {
            $('#logout-btn').text('Login')
        }
    }
        
    });
    $('#profile-popup').toggle();

    });


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
                    showMessage('warning', res.message);
                }
            },
            error: function(){
                showMessage('error', 'Error loading profile.');
            }
        });
    });

    // Handle profile update
    $('#profile-form').on('submit', function(e){
        e.preventDefault();
       console.log($(this).serialize())
        $.ajax({
            url: 'update_user.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res){
                if(res.status === 'success'){
                      showMessage('success', res.message);
                      fetch_name();
                } else {
                    showMessage('warning', res.message);
                }
            },
            error: function(){
                showMessage('error', 'Error updating profile.');
            }
        });
    });


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
        data: { user_id: userId },
        dataType: 'json',
        success: function(response) {
            const friendList = $('#friend-list');
            friendList.empty(); // clear existing content

            if (response.status === 'success' && response.friends.length > 0) {
                $('#friends-count').text(response.total_friends+' Friends')
                response.friends.forEach(friend => {
                    friendList.append(`
                       <a href="dashboard.php?user_id=${friend.User_id}">
                        <div class="d-flex align-items-center mb-3"> <div class="d-inline-block text-center me-3 mt-3">
                            <img src="img/default-friend-image.jpg" 
                                alt="${friend.Name}" 
                                class="rounded mb-2 friend-images-content" >
                            <h6 class="mb-0">${friend.Name}</h6>
                        </div>
                       </a>
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


    function fetch_name(){
            $.ajax({
        url: 'fetch_name.php',
        type: 'GET',
        data: { user_id: userId },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#profile-username').text(response.name);
                response.is_self ? '' : $('#post-form-container').hide();
            } else {
                console.log("Error:", response.message);
            }
        },
        error: function() {
            console.log("Error fetching name");
        }
    });
    }



    //  Common message display function
    function showMessage(type, message) {
        const alertClass = type === 'success' ? 'alert-success' :
                           type === 'error'   ? 'alert-danger'  :
                           type === 'warning' ? 'alert-warning' : 'alert-info';
        
        $('#form-message')
            .stop(true, true)
            .hide()
            .html(`<div class="alert ${alertClass} text-center position-fixed top-0 start-50 translate-middle-x mt-3 shadow">${message}</div>`)
            .fadeIn(300)
            .delay(2000)
            .fadeOut(500);
    }



    $('#profileModal').on('click', '.edit-btn, .feild-cancel-btn', function() {
    const input = $(this).closest('.field-section-container').find('input'); // find related input
    const buttons = $(this).closest('.field-section-container').find('.field-save-btn'); 
    const edit_btn = $(this).closest('.field-section-container').find('.edit-btn'); 
    // Toggle input enable/disable
    if (input.prop('disabled')) {
        input.addClass('enabled');
        buttons.removeClass('d-none');
        input.prop('disabled', false).focus(); // enable and focus
        edit_btn.text('Cancel');
    } else {
        input.removeClass('enabled');
        buttons.addClass('d-none');
        input.prop('disabled', true); // disable again
        edit_btn.text('Edit');
    }
  });

});
