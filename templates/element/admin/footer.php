 <!-- Footer -->
 <footer class="sticky-footer bg-white">
     <div class="container my-auto">
         <div class="copyright text-center my-auto">
             <span>Copyright &copy; Your Website 2020</span>
         </div>
     </div>
 </footer>

 </div>

 </div>

 <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
 </a>

 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                 <a class="btn btn-primary" href="/auths/logout">Logout</a>
             </div>
         </div>
     </div>
 </div>

 <script src="/vendor/jquery/jquery.min.js"></script>
 <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

 <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

 <script src="/js/admin/sb-admin-2.min.js"></script>


 </body>
 <script>
     // tooltip icon
     $(document).ready(function() {
         $('[data-toggle="tooltip"]').tooltip();
     });
     // array controller want back
     const arrUrlPrePage = [
         'categories',
         'survies',
         'answers',
         'users'
     ];
     $('.back').click((e) => {
         if (document.referrer == '') {
             for (let i = 0; i < arrUrlPrePage.length; i++) {
                 if (window.location.href.indexOf(arrUrlPrePage[i]) > -1) {
                     window.location.href = '/admin/' + arrUrlPrePage[i]
                 }
             }
         } else {
             window.history.back()
         }
     })

     // click once button
     $('button[type="submit"]').click((e) => {
         e.preventDefault()
         $('button[type="submit"]')
             .attr('disabled', 'disabled');
         $(e.target).parents('form').submit()
     })

     //back
     function back(event) {
         event.preventDefault();
         window.history.back();
     }

     // back page previous
     function backPrePage() {
         <?php if (isset($_SESSION['oldPage'])) { ?>
             <?php if ($_SESSION['oldPage'] == '') { ?>
                 for (let i = 0; i < arrUrlPrePage.length; i++) {
                     if (window.location.href.indexOf(arrUrlPrePage[i]) > -1) {
                         window.location.href = '/admin/' + arrUrlPrePage[i]
                     }
                 }
             <?php } else { ?>
                 window.location.href = "<?= $_SESSION['oldPage'] ?>";
             <?php } ?>
         <?php } else { ?>
             window.history.back();
         <?php } ?>
     }

     // add icon in attribule th
     //  $('th:not(th:first-child):not(th:last-child)').append(' <i class="fa fa-sort-down"></i>')

     //  // sort data in table
     //  $("table thead").on("click", "th:not(th:first-child):not(th:last-child)", function() {
     //      var index = $(this).index();
     //      var tbody = $(this).closest("table").find("tbody");
     //      var rows = tbody.children().detach().get();
     //      var dir = $('table').data('sort')
     //      if (dir == 'asc') {
     //          rows.sort(function(left, right) {
     //              var left = $(left).children().eq(index);
     //              var right = $(right).children().eq(index);
     //              return left.text().localeCompare(right.text());
     //          });
     //          tbody.append(rows);
     //          $('table').data('sort', 'desc')
     //          $('th i').attr('class', 'fa fa-sort-up')
     //      }
     //      if (dir == 'desc') {
     //          rows.reverse(function(left, right) {
     //              var left = $(left).children().eq(index);
     //              var right = $(right).children().eq(index);
     //              return left.text().localeCompare(right.text());
     //          });
     //          tbody.append(rows);
     //          $('table').data('sort', 'asc')
     //          $('th i').attr('class', 'fa fa-sort-down')
     //      }
     //  });
 </script>

 </html>