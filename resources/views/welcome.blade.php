<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>

         

        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="input-field col s4">
                                  <input placeholder="Enter Name" type="text" id="name_field" class="validate">
                                  <label for="name">Name</label>
                                </div>
                                <div class="input-field col s4">
                                    <input placeholder="Enter email" type="text" id="email_field" class="validate">
                                    <label for="email">Email</label>
                                </div>
                                <div class="input-field col s4">
                                    <input placeholder="Enter ID" type="text" id="id_field" class="validate">
                                    <label for="id">ID</label>
                                </div>
                               
                            </div>
                            <div class="row">
                              <div class="input-field col s3">
                                  <input placeholder="Enter Search value" type="text" id="all_search" class="validate">
                                  <label for="name">Search All</label>
                              </div>
                            </div>
                        </div>
                       
                      </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                          
                        <tbody>
                           
                        </tbody>
                    </table>
                    <ul class="pagination">
                        
                    </ul>
                </div>
            </div>
        </div>
      <input type="hidden" name="ajax_url" id="ajax_url" value="{{url('/')}}">
      <!--JavaScript at end of body for optimized loading-->
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script>
        var pagination_number;
        $(document).ready(function(){
          var url = $('#ajax_url').val();
         
          $.get(url+'/get-full-data',function(response){
            console.log(response.data);
            pagination_number = response.last_page;
              $.each(response.data,function(key,val){
                  var html = `<tr>
                                  <td>${val.id}</td>
                                  <td>${val.name}</td>
                                  <td>${val.email}</td>
                              </tr>`;
                  $('tbody').append(html);
              })
              var paginationBtns = getPagination(response.current_page,response.last_page,response.path);
              $('ul').append(paginationBtns);
          })
        })

        function getPagination(current,last,path){
          var html = "";
          html += `<li class="disabled"><a href="#!" rel="" id="prev_btn"><i class="material-icons">chevron_left</i></a></li>`;
          for(var i=current;i<=last;i++){
             if(i === current){
              html += `<li class="waves-effect active"><a href="#" rel="${path}?page=${i}" id="pagination_btn">${i}</a></li>`;
             }else{
              html += `<li class="waves-effect"><a href="#" rel="${path}?page=${i}" id="pagination_btn">${i}</a></li>`; 

             }
          }
          html += `<li class="waves-effect"><a href="#!" rel="${path}?page=${current+1}" id="next_btn"><i class="material-icons">chevron_right</i></a></li>`;

          return html;
        }

        $(document).on('click','#pagination_btn',function(){
           $('tbody').empty();
           var url = $(this).attr('rel');
           $.get(url,function(response){
            pagination_number = response.last_page;
              $.each(response.data,function(key,val){
                  var html = `<tr>
                                  <td>${val.id}</td>
                                  <td>${val.name}</td>
                                  <td>${val.email}</td>
                              </tr>`;
                  $('tbody').append(html);
              })
          })
          var activeBtn = $("li.active");
          activeBtn.removeClass('active');
          $(this).parent().addClass('active');
          if($(this)[0].innerHTML == pagination_number){
            $('#next_btn').parent().addClass('disabled');
            $(this).parent().removeClass('waves-effect');
          }

          
          var prev_page_num = parseInt($(this)[0].innerHTML)-1;
          //console.log(prev_page_num);
          
          if($(this)[0].innerHTML !== 1){
            $('#prev_btn').parent().removeClass('disabled');
            $('#prev_btn').parent().addClass('waves-effect');
            $('#prev_btn').attr('rel',url.slice(0,41)+prev_page_num);
          }
          if($(this)[0].innerHTML == 1){
            $('#prev_btn').parent().addClass('disabled');
            $('#prev_btn').parent().removeClass('waves-effect');
            $('#prev_btn').attr('rel',"");
          }


        })

        $(document).on('click','#next_btn',function(){
           $('tbody').empty();
           var url = $(this).attr('rel');
         
           $.get(url,function(response){
              $.each(response.data,function(key,val){
                  var html = `<tr>
                                  <td>${val.id}</td>
                                  <td>${val.name}</td>
                                  <td>${val.email}</td>
                              </tr>`;
                  $('tbody').append(html);
              })
          })
          var activeBtn = $("li.active");
          var next_page_number = parseInt($("li.active a")[0].innerHTML)+1;
          if(next_page_number == pagination_number){
            $(this).parent().removeClass('waves-effect');
            $(this).parent().addClass('disabled');

          }
          var allList = $("li a#pagination_btn");
          $.each(allList,function(key,val){
            if(val.innerHTML == next_page_number){
              console.log($(val).parent().addClass('active'))
            }
          })
          $(this).attr('rel',url.slice(0,41)+next_page_number);
          activeBtn.removeClass('active');
            var prev_page_num = parseInt($("li.active a")[0].innerHTML)-1;
            $('#prev_btn').parent().removeClass('disabled');
            $('#prev_btn').parent().addClass('waves-effect');
            $('#prev_btn').attr('rel',url.slice(0,41)+prev_page_num);

        })

        $(document).on('click','#prev_btn',function(){
           $('tbody').empty();
           var url = $(this).attr('rel');
           $.get(url,function(response){
              $.each(response.data,function(key,val){
                  var html = `<tr>
                                  <td>${val.id}</td>
                                  <td>${val.name}</td>
                                  <td>${val.email}</td>
                              </tr>`;
                  $('tbody').append(html);
              })
           })
          prev_page_number = url.substr(41,url.length-41)
          var activeBtn = $("li.active");
          var next_page_number = parseInt($("li.active a")[0].innerHTML)+1;
          if(next_page_number == pagination_number){
            $('#next_btn').parent().removeClass('waves-effect');
            $('#next_btn').parent().addClass('disabled');
          }else{
            $('#next_btn').parent().addClass('waves-effect');
            $('#next_btn').parent().removeClass('disabled');
            $('#next_btn').attr('rel',url.slice(0,41)+next_page_number);
          }
          var new_pre_num = parseInt(prev_page_number)-1;
          //console.log(new_pre_num);
          var allList = $("li a#pagination_btn");
          $.each(allList,function(key,val){
            if(val.innerHTML == new_pre_num){
              console.log($(val).parent().addClass('active'))
            }
          })
          
          if(new_pre_num == 1){
            $(this).parent().addClass('disabled');
            $(this).parent().removeClass('waves-effect');
            $(this).attr('rel',"");
          }
          $(this).attr('rel',url.slice(0,41)+new_pre_num);
           activeBtn.removeClass('active');
        })

        $(document).on('keyup','#all_search',function(){
              var search_tag = $('#all_search').val()||"none";
              $('tbody').empty();
              $('ul').empty();
              var url = $('#ajax_url').val();
              var name = $('#name_field').val()||"none";
              var email = $('#email_field').val()||"none";
              var id = $('#id_field').val()||"none";
              $.get(url+'/get-search-data/'+name+'/'+email+'/'+id+'/'+search_tag,function(response){
                console.log(response.data);
                pagination_number = response.last_page;
                  $.each(response.data,function(key,val){
                      var html = `<tr>
                                      <td>${val.id}</td>
                                      <td>${val.name}</td>
                                      <td>${val.email}</td>
                                  </tr>`;
                      $('tbody').append(html);
                  })
                  var paginationBtns = getPagination(response.current_page,response.last_page,response.path);
                  $('ul').append(paginationBtns);
              })
        })

        $(document).on('keyup','#name_field',function(){
              var search_tag = $('#all_search').val()||"none";
              $('tbody').empty();
              $('ul').empty();
              var url = $('#ajax_url').val();
              var name = $('#name_field').val()||"none";
              var email = $('#email_field').val()||"none";
              var id = $('#id_field').val()||"none";
              $.get(url+'/get-search-data/'+name+'/'+email+'/'+id+'/'+search_tag,function(response){
                console.log(response.data);
                pagination_number = response.last_page;
                  $.each(response.data,function(key,val){
                      var html = `<tr>
                                      <td>${val.id}</td>
                                      <td>${val.name}</td>
                                      <td>${val.email}</td>
                                  </tr>`;
                      $('tbody').append(html);
                  })
                  var paginationBtns = getPagination(response.current_page,response.last_page,response.path);
                  $('ul').append(paginationBtns);
              })
        })

        $(document).on('keyup','#email_field',function(){
              $('tbody').empty();
              $('ul').empty();
              var url = $('#ajax_url').val();
              var search_tag = $('#all_search').val()||"none";
              var name = $('#name_field').val()||"none";
              var email = $('#email_field').val()||"none";
              var id = $('#id_field').val()||"none";
              $.get(url+'/get-search-data/'+name+'/'+email+'/'+id+'/'+search_tag,function(response){
                console.log(response.data);
                pagination_number = response.last_page;
                  $.each(response.data,function(key,val){
                      var html = `<tr>
                                      <td>${val.id}</td>
                                      <td>${val.name}</td>
                                      <td>${val.email}</td>
                                  </tr>`;
                      $('tbody').append(html);
                  })
                  var paginationBtns = getPagination(response.current_page,response.last_page,response.path);
                  $('ul').append(paginationBtns);
              })
        })

        $(document).on('keyup','#id_field',function(){
              $('tbody').empty();
              $('ul').empty();
              var url = $('#ajax_url').val();
              var search_tag = $('#all_search').val()||"none";
              var name = $('#name_field').val()||"none";
              var email = $('#email_field').val()||"none";
              var id = $('#id_field').val()||"none";
              $.get(url+'/get-search-data/'+name+'/'+email+'/'+id+'/'+search_tag,function(response){
                console.log(response.data);
                pagination_number = response.last_page;

                  $.each(response.data,function(key,val){
                      var html = `<tr>
                                      <td>${val.id}</td>
                                      <td>${val.name}</td>
                                      <td>${val.email}</td>
                                  </tr>`;
                      $('tbody').append(html);
                  })
                  var paginationBtns = getPagination(response.current_page,response.last_page,response.path);
                  $('ul').append(paginationBtns);
              })
        })
      
      </script>
    </body>
  </html>