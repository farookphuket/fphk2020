<section id="ustd">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center head">
                    What's going on <?php echo $today; ?>?
                </h1>
                <p>&nbsp;</p>
            </div>
            <div class="col-lg-12">
                <ul class="list-group st_list">
                </ul>
                <div class="st_pagin">
                </div>
            </div>
        </div>
    </div>
  </section>
<script charset="utf-8">
$(function(){


    const $WT = (function(){


        //-- use Cookies
        let WT_page = Cookies.get("WT_page");
        if(!WT_page || WT_page === 0){
            WT_page = 1;
        }
        let $st_list = getEl(".st_list");
        let $st_pagin = getEl(".st_pagin");

        function getWhatNewList(page=1){
            $st_list.html("");
            let url = "<?php echo site_url("ustd/getWhatNewList/"); ?>"+page;

            $.ajax({
                url : url,
                success : function(e){

                    let rs = $.parseJSON(e);
                    $.each(rs.get_all,(i,v)=>{
                          let tmp = `<li class="list-group-item">
                            <div class="container">
                                ${v.st_sum}
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>
                                                On 
                                            </th>
                                            <td>
                                                ${v.date_create}
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>
                                                title 
                                            </th>
                                            <td>
                                                ${v.st_title}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </li><p class="pt-2">&nbsp;</p>`;  
                        $st_list.append(tmp);
                    });
                    if(rs.pagination){
                        $st_pagin.html(rs.pagination);
                    }
                }
            });
        }

        function getEl(el){
            return $(el);     
        }
        function getEvent(){
            getWhatNewList(WT_page);
            //console.log(`wt is ${WT_page}`);
            $st_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                let page = $(this).attr("data-ci-pagination-page");
                Cookies.set('WT_page',page);
                getWhatNewList(page); 
                 
            });
        }
        return{getEvent:getEvent}
    })();
    $WT.getEvent();
});




</script>





<section id="tour">
      <div class="container-fluid">

        <div class="row">
          <div class="col-lg-12 text-center">
              <h2 class="section-heading">Our tour program
              <span class="badge badge-secondary num_tour">0</span> item(s).
              </h2>
              <p>
                  <a class="btn btn-primary " href="<?php echo site_url("tour");?>">See all</a> -OR-
                  <a class="btn btn-info js-scroll-trigger" href="#checkBooking">Check My Booking</a>

              </p>

              <hr class="my-4">
          </div>
        </div>
      </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <!--dynamic content-->
              <div class="tour_list">

                </div>
                <div class="tour_pagin">

                </div>
                <p class="pt-2">&nbsp;</p>
            <!--end of dynamic content-->

          </div>

        </div>
      </div>
</section>

<section id="article">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 text-center">
              <h2 class="section-heading">Recently Post
              <span class="badge badge-secondary num_post">0</span> item(s).
              </h2>
              <a class="btn btn-primary btnSeeAll" href="<?php echo site_url("article");?>">See All</a>
              <hr class="my-4">
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-12 ">

                <!--dynamic content start-->
                <div class="show-list">
                  <div class="post_recent">

                  </div>

                </div>

                <div class="post_pagin">

                </div>
                <!--dynamic content end-->

            </div>
          </div>
        </div>
      </section>
<script>
    $(function(){

        //--- last update 19-dec-2019
        const $AP = $("#article");
        const $ar = (function(){

            const $show_num = getEl(".num_post");
            const $ar_list = getEl(".post_recent");
            const $ar_pagin = getEl(".post_pagin");


            //-----getPostList---
            function getPostList(page=1){
                $ar_list.html("");
                let url = "<?php echo site_url("article/arGetList/"); ?>"+page;
                $.ajax({
                    url : url,
                        success : (e)=>{
                        let rs = $.parseJSON(e);
                        //console.log(rs);
                        if(rs.get_all.length !== 0){
                            $show_num.html(rs.num);
                            $.each(rs.get_all,(i,v)=>{
                            let read_link = "<?php echo site_url("article/read/"); ?>"+v.uniq_id;
                            let read_url = `<a href="${read_link}" class="btn btn-primary text-white lnRead" data-uniq_id="${v.uniq_id}" target="_blank">Read More</a>`;
                            let tmp = `<div class="card">
                                <div class="card-header bg-primary">
                                    <h1 class="text-white">${v.ar_title}</h1>
                                </div>
                                <div class="card-body">
                                ${v.ar_summary}
                                    <div class="table-responsive">
                                    <table class="table table-borderd">
       <tr>
           <th>Post By</th>
           <td>${v.ar_post_by}</td>
       </tr>                                 
        <tr>
           <th>Post Date</th>
           <td>Create : ${v.date_add} | update : ${v.date_edit}</td>
       </tr>   
         <tr>
           <th>Read</th>
           <td>${v.ar_read_count}</td>
           </tr> 
           
           </table>
                                        
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="float-right">
                                        ${read_url}
                                    </div>
                                </div>
</div><p>&nbsp;</p>`;
                            $ar_list.append(tmp);
                            });
                            if(rs.pagination){
                                $ar_pagin.html(rs.pagination);
                            }
                        } 
                }
                });
            }
            //--------------
            //-- setReadCount 
            function readPost(id){
                let url = "<?php echo site_url("article/read/"); ?>"+id;
                let win = window.open(url,'_blank');
                setTimeout(()=>{
                    getSummary();
                },400);
            }
            //---getSummary
            function getSummary(){
                getPostList();
            }
            //----------------
            //----getEl---
            function getEl(el){
                return $AP.find(el);
            }
            //---------
            function getEvent(){
                getSummary();

                //---update read count
                $ar_list.delegate(".lnRead","click",function(e){
                    e.preventDefault();
                    let id = $(this).attr("data-uniq_id");
                    //osetReadCount(id);
                    readPost(id);
                });

                //---pagination
                $ar_pagin.delegate(".pagination a","click",function(e){
                    e.preventDefault();
                    let page = $(this).attr("data-ci-pagination-page");
                    getPostList(page);
                });
            }
            return{getEvent:getEvent}
        })();
        $ar.getEvent();
    });
</script>
<!-- update script 19-dec-2019 -->

     





