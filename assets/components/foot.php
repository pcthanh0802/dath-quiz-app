        </div>
        </div>

        <script src="assets/js/bootstrap.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('.datatable').DataTable({
                    scrollY: '250px',
                    scrollCollapse: true,
                    paging: false,
                    info: false,
                    "autoWidth": true
                });
                var reqTable = $('.reqTable').DataTable({
                    scrollY: '650px',
                    scrollCollapse: true,
                    paging: false,
                    info: false,
                    "autoWidth": true
                });
            });
        </script>
        </body>

        </html>