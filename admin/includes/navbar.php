<!-- Sidebar -->
<aside class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" 
    id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-"></i>
        </div>

        <div class="sidebar-brand-text mx-3"> Admin</div>

    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->


    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>



    <li class="nav-item">
        <a class="nav-link" href="departments.php">
            <i class="fas fa-fw fa-book"></i>
            <span>Departments</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="teachers.php">
            <i class="fa fa-user-graduate"></i>
            <span>Teachers</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="student_fee.php">
            <i class="fa fa-user-graduate"></i>
            <span>Student Fee</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="events.php">
            <i class="fa fa-calendar"></i>
            <span> Events</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="time_table.php">
            <i class="fa fa-clock"></i>
            <span> Time Table</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="grading.php">
            <i class="fa fa-calendar"></i>
            <span> Grading</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->


</aside>
<!-- End of Sidebar -->


<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Are you sure to logout?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>