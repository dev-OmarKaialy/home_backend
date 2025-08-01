     <aside class="menu-sidebar d-none d-lg-block">
         <div class="logo">
             <a href="#">
                 <img src="images/icon/logo.png" alt="Cool Admin" />
             </a>
         </div>
         <div class="menu-sidebar__content js-scrollbar1">
             <nav class="navbar-sidebar">
                 <ul class="list-unstyled navbar__list">
                     <li>
                         <a href="{{route('dashboard')}}">
                             <i class="fas fa-chart-bar"></i>Dashboard</a>
                     </li>
                     <li>
                         <a href="{{route('houses.index')}}">
                             <i class="fas fa-chart-bar"></i>Houses</a>
                     </li>
                     <li>
                         <a href="{{route('services.index')}}">
                             <i class="fas fa-chart-bar"></i>Services</a>
                     </li>
                     <li>
                         <a href="{{route('categories.index')}}">
                             <i class="fas fa-chart-bar"></i>Categories</a>
                     </li>
                 </ul>
             </nav>
         </div>
     </aside>