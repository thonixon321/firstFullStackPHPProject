/*

           d8b
           Y8P

  8888b.  8888  8888b.  888  888
     "88b "888     "88b `Y8bd8P'
 .d888888  888 .d888888   X88K
 888  888  888 888  888 .d8""8b.
 "Y888888  888 "Y888888 888  888
           888
          d88P
        888P"

*/
//ajax function - runs for all ajax calls
var ajaxIt = {
  url: '',

  send: function (ajaxObj) {
    //if no url is added, use default
    if (ajaxObj.url == undefined) {
      ajaxObj.url = ajaxIt.url;
    }
    console.log(ajaxObj);
    $.ajax({
      url: ajaxObj.url,
      type: ajaxObj.type,
      data: ajaxObj.dataObj
    }).done(function(msg) {
      ajaxObj.doneCall(msg);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR, textStatus, errorThrown);
         alert('Something went wrong with this ajax request.');

         if (typeof ajaxObj.failCall === 'function') {
           ajaxObj.failCall();
         }
    });

  }
};



/*

                            888
                            888
                            888
 88888b.   .d88b.  .d8888b  888888 .d8888b
 888 "88b d88""88b 88K      888    88K
 888  888 888  888 "Y8888b. 888    "Y8888b.
 888 d88P Y88..88P      X88 Y88b.       X88
 88888P"   "Y88P"   88888P'  "Y888  88888P'
 888
 888
 888

*/

var posts = {
  getPosts: function() {
    var dataObj = {};
    var ajaxObj = {
      url: 'http://localhost:8080/rest_myBlog/api/post/read.php',
      type: 'GET',
      dataObj: dataObj,
      doneCall: posts.getPostsResponse
    };

    ajaxIt.send(ajaxObj);
  },


  getPostsResponse(res) {
    console.log(res);
    $('.submitPost').removeClass('editing');
    res.data.forEach(function(el){
      $('.posts').append(
        '<div class="postContainer">'+
          '<h2>'+el.title+'</h2> <br>'+
          '<p>'+el.body+'</p> <br>'+
          '<p>'+el.author+'</p>'+
          '<form>'+
           '<button data-deleteid="'+el.id+'" class="deletePost">Delete</button>'+
          '</form>'+
          '<button data-id="'+el.id+'" class="postContainerEdit">Edit</button>'+
        '</div>'
      );
    });
  },


  getSinglePost: function() {
    var $this = $(this);
    var id = $this.data('id');
    var dataObj = {};
    console.log(id);
    var ajaxObj = {
      url: 'http://localhost:8080/rest_myBlog/api/post/read_single.php?id='+id,
      type: 'GET',
      dataObj: dataObj,
      doneCall: posts.getSinglePostResponse
    };

    ajaxIt.send(ajaxObj);
  },


  getSinglePostResponse: function(res) {
    var category_id;

    console.log(res);

    $('.submitPost').addClass('editing').data('id', res.id);
    $('.createPostForm').removeClass('hide');
    $('.posts').addClass('hide');


    if (res.category_name === 'Technology') {
      category_id = 1;
    }
    else if (res.category_name === 'Gaming') {
      category_id = 2;
    }
    else if (res.category_name === 'Auto') {
      category_id = 3;
    }
    else if (res.category_name === 'Entertainment') {
      category_id = 4;
    }
    else{
      category_id = 5;
    }

    $('#title').val(res.title);
    $('#textBody').val(res.body);
    $('#author').val(res.author);
    $('#categoryType').val(category_id);

  },


  createPost: function() {
    var url;
    var dataObj = {
      id: $('.submitPost').data('id'),
      title: $('#title').val(),
      body: $('#textBody').val(),
      author: $('#author').val(),
      category_id: $('#categoryType').val()
    };

    if ($('.submitPost').hasClass('editing')) {
      url = 'http://localhost:8080/rest_myBlog/api/post/update.php';
    }
    else{
      url = 'http://localhost:8080/rest_myBlog/api/post/create.php';
    }

    var ajaxObj = {
      url: url,
      type: 'POST',
      dataObj: dataObj,
      doneCall: posts.createPostResponse
    };

    ajaxIt.send(ajaxObj);
  },


  createPostResponse: function(res) {
    console.log(res);
  },

  deletePost: function() {
    var $this = $(this);
    var id = $this.data('deleteid');
    var dataObj = {
      id: id
    };

    var ajaxObj = {
      url: 'http://localhost:8080/rest_myBlog/api/post/delete.php',
      type: 'POST',
      dataObj: dataObj,
      doneCall: posts.deletePostResponse
    };

    ajaxIt.send(ajaxObj);
  },

  deletePostResponse: function(res) {
    console.log(res);
  }
};

/*


 88888b.   8888b.   .d88b.   .d88b.
 888 "88b     "88b d88P"88b d8P  Y8b
 888  888 .d888888 888  888 88888888
 888 d88P 888  888 Y88b 888 Y8b.
 88888P"  "Y888888  "Y88888  "Y8888
 888                    888
 888               Y8b d88P
 888                "Y88P"

*/

var page = {
  showCreatePost: function() {
    $('.submitPost').removeClass('editing');
    $('.createPostForm').removeClass('hide');
    $('.posts').addClass('hide');

    $('#title').val('');
    $('#textBody').val('');
    $('#author').val('');
    $('#categoryType').val('');
  },


  load: function() {
    posts.getPosts();
  },


  events: function() {
    $('body').on('click', '.postContainerEdit', posts.getSinglePost);
    $('body').on('click', '.createPost', page.showCreatePost);
    $('body').on('click', '.submitPost', posts.createPost);
    $('body').on('click', '.deletePost', posts.deletePost);
  }
};



$(document).ready(function(){
  page.load();
  page.events();
});