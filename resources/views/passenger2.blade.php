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
      <style>
         li.hidden_btn{
             display: none;
         }
      </style>
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
            pagination_number = response.last_page;
            createNextBtn(response.next_page_url);
            createPreviousBtn(response.prev_page_url);
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
                html += `<li class="waves-effect active visible_btn"><a href="#" rel="${path}?page=${i}" id="pagination_btn">${i}</a></li>`;
                }else if(i>10){
                html += `<li class="waves-effect hidden_btn" ><a href="#" rel="${path}?page=${i}" id="pagination_btn">${i}</a></li>`; 
                }else{
                html += `<li class="waves-effect visible_btn" ><a href="#" rel="${path}?page=${i}" id="pagination_btn">${i}</a></li>`; 
                }
            }
            html += `<li class="waves-effect visible_btn" ><a href="#" rel="">...</a></li>`;
            html += `<li class="waves-effect visible_btn" ><a href="#" rel="${path}?page=${last}" id="pagination_btn">${last}</a></li>`; 
 
            html += `<li class="waves-effect"><a href="#!" rel="${path}?page=${current+1}" id="next_btn"><i class="material-icons">chevron_right</i></a></li>`;
          
        

          return html;
        }

        $(document).on('click','#pagination_btn',function(){
           $('tbody').empty();
           var url = $(this).attr('rel');
           $.get(url,function(response){
             pagination_number = response.last_page;
             createNextBtn(response.next_page_url);
             createPreviousBtn(response.prev_page_url);
              $.each(response.data,function(key,val){
                  var html = `<tr>
                                  <td>${val.id}</td>
                                  <td>${val.name}</td>
                                  <td>${val.email}</td>
                              </tr>`;
                  $('tbody').append(html);
              })
            })

            //GIVE ACTIVE BUTTON CLASS
            var activeBtn = $("li.active");
            activeBtn.removeClass('active');
            $(this).parent().addClass('active');
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
                createNextBtn(response.next_page_url);
                createPreviousBtn(response.prev_page_url);
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
                createNextBtn(response.next_page_url);
                createPreviousBtn(response.prev_page_url);
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
                createNextBtn(response.next_page_url);
                createPreviousBtn(response.prev_page_url);
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
                createNextBtn(response.next_page_url);
                createPreviousBtn(response.prev_page_url);
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

        $(document).on('click','#prev_btn',function(){
            $('tbody').empty();
            var url = $(this).attr('rel');
            num_position = parseInt(url.search(/page=/i));
            var prev_page_number = url.substr(num_position+5,url.length);
            var path;
            //console.log(prev_page_number);
            $.get(url,function(response){
             path = response.path;
             pagination_number = response.last_page;
             createNextBtn(response.next_page_url);
             createPreviousBtn(response.prev_page_url);
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
            var allList = $("li a#pagination_btn");
            var firstListElement = allList[0].textContent;
            var lastListElement = allList[allList.length-1].textContent;
            if(prev_page_number === firstListElement){
                if(prev_page_number != 1){
                   $('ul').empty();
                   previousPaginationNumber(prev_page_number,url.substr(0,num_position+5));
                }
                
            }
            $.each(allList,function(key,val){
                if(val.innerHTML == parseInt(prev_page_number)){
                   $(val).parent().addClass('active');
                }
            })
        })

        $(document).on('click','#next_btn',function(){
            $('tbody').empty();
            var url = $(this).attr('rel');
            num_position = parseInt(url.search(/page=/i));
            var next_page_number = parseInt(url.substr(num_position+5,url.length));
            var path;
            
            $.get(url,function(response){
             pagination_number = response.last_page;
             createNextBtn(response.next_page_url);
             createPreviousBtn(response.prev_page_url);
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
            var allList = $("li a#pagination_btn");
            var lastListElement = allList[allList.length-1].textContent;
            if(next_page_number > 10){
                if(parseInt(lastListElement)+1 != pagination_number){
                    $('ul').empty();
                    nextPaginationDesign(next_page_number,url.substr(0,num_position+5));
                }
            }
            $.each(allList,function(key,val){
                if(val.innerHTML == parseInt(next_page_number)){
                   $(val).parent().addClass('active');
                }
            })

            
        })

        function createNextBtn(next_page_url){
            //console.log($('#next_btn').parent()[0]);
            if(next_page_url !== null){
                $('#next_btn').attr('rel',next_page_url);
                $('#next_btn').parent().removeClass('disabled');
                $('#next_btn').parent().addClass('waves-effect');
            }else{
                $('#next_btn').parent().addClass('disabled');
                $('#next_btn').parent().removeClass('waves-effect');
            }
        }

        function createPreviousBtn(prev_page_url){
            if(prev_page_url !== null){
                $('#prev_btn').attr('rel',prev_page_url);
                $('#prev_btn').parent().removeClass('disabled');
                $('#prev_btn').parent().addClass('waves-effect');
            }else{
                $('#prev_btn').parent().addClass('disabled');
                $('#prev_btn').parent().removeClass('waves-effect');
            }
        }

        function nextPaginationDesign(next_page_number,path){
            var html = "";
            var n = parseInt(next_page_number);
            if(n<=pagination_number-2){
                html += `<li class="waves-effect"><a href="#!" rel="" id="prev_btn"><i class="material-icons">chevron_left</i></a></li>`;
                    for(var i=n-8;i<=n+1;i++){
                        if(n<pagination_number){
                            if(i === n){
                            html += `<li class="waves-effect active "><a href="#" rel="${path}${i}" id="pagination_btn">${i}</a></li>`;
                            }else{
                            html += `<li class="waves-effect" ><a href="#" rel="${path}${i}" id="pagination_btn">${i}</a></li>`; 
                            }
                        }else{
                            continue;
                        }
                    }
                html += `<li class="waves-effect visible_btn" ><a href="#" rel="">...</a></li>`;
                html += `<li class="waves-effect visible_btn" ><a href="#" rel="${path}?page=${pagination_number}" id="pagination_btn">${pagination_number}</a></li>`;            
                html += `<li class="waves-effect"><a href="#!" rel="${path}${n+2}" id="next_btn"><i class="material-icons">chevron_right</i></a></li>`;
            }else{
                html += `<li class="waves-effect"><a href="#!" rel="" id="prev_btn"><i class="material-icons">chevron_left</i></a></li>`;
                    for(var i=n-8;i<=n+1;i++){
                        if(n<pagination_number){
                            if(i === n){
                            html += `<li class="waves-effect active "><a href="#" rel="${path}${i}" id="pagination_btn">${i}</a></li>`;
                            }else{
                            html += `<li class="waves-effect" ><a href="#" rel="${path}${i}" id="pagination_btn">${i}</a></li>`; 
                            }
                        }else{
                            continue;
                        }
                    }           
                html += `<li class="waves-effect"><a href="#!" rel="${path}${n}" id="next_btn"><i class="material-icons">chevron_right</i></a></li>`;
            }
                
                                
                $('ul').append(html); 
        }

        function previousPaginationNumber(prev_page_number,path){
            var html = "";
            var n = parseInt(prev_page_number);
            html += `<li class="waves-effect"><a href="#!" rel="" id="prev_btn"><i class="material-icons">chevron_left</i></a></li>`;
            for(var i=n-1;i<=n+9;i++){
                if(i === n){
                html += `<li class="waves-effect active "><a href="#" rel="${path}${i}" id="pagination_btn">${i}</a></li>`;
                }else{
                html += `<li class="waves-effect" ><a href="#" rel="${path}${i}" id="pagination_btn">${i}</a></li>`; 
                }
            }
            html += `<li class="waves-effect"><a href="#!" rel="${path}${n+2}" id="next_btn"><i class="material-icons">chevron_right</i></a></li>`;
            $('ul').append(html);
        }
      
      </script>
    </body>
  </html>