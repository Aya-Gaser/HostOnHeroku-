<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Work Needed
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('management.create-wo')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create WO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('management.view-allWo')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View All WO</p>
                </a>
              </li>
             
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Projects
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <li class="nav-item">
                <a href="{{route('management.view-allProjects', 'pending') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>On Progress Projects</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('management.view-allProjects', 'completed') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Completed Projects</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('management.view-allProjects', 'all') }}" 
                class="nav-link {{ isActive('management.view-allProjects')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Projects</p>
                </a>
              </li>
              
            </ul>
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Vendors
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('management.view-allVendors')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Vendor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('management.view-allVendors')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View All Vendors</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
               Clients
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('management.create-client')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Client</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('management.view-allClients')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>View All Clients</p>
                </a>
              </li>
             
              </ul>
          </li>
          <br>
          <hr style="background-color:#ccc;">
          <li class="nav-item">
                <a href="{{route('management.admin-profile',Auth::user()->id)}}" class="nav-link">
                  <i class="far fa-user nav-icon"></i>
                  <p>My Profile</p>
                </a>
              </li>
        <li class="nav-item">   
         
         <a class="nav-link" href="{{ route('logout') }}"
             onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt nav-icon"></i> 
            <p> {{ __('Logout') }} </p> 
         </a>

         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
             @csrf
         </form>
    
      </li>    
          
        </ul>

</nav>
