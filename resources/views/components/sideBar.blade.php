<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img
                src="{{asset('assets/img/kaiadmin/logo_light.svg')}}"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  data-bs-toggle="collapse"
                  href="#dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class="caret"></span>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li>
              
              @if(Auth::check() && Auth::user()->role->name === 'Super Admin')
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#admin">
                  <i class="fas fa-user-shield"></i>
                  <p>Administration</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="admin">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{ route('users.index') }}">
                        <span class="sub-item">User Management</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif
              
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#forms">
                  <i class="fas fa-pen-square"></i>
                  <p>Forms</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="forms">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="forms/forms.html">
                        <span class="sub-item">Basic Form</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#rpa">
                  <i class="fas fa-robot"></i>
                  <p>RPA</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="rpa">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{ route('rpa.template.index') }}">
                        <span class="sub-item">Template</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('rpa.action.index') }}">
                        <span class="sub-item">Action list</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('rpa.process.index') }}">
                        <span class="sub-item">Process</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('jobs.index') }}">
                        <span class="sub-item">Job Status</span>
                      </a>
                    </li>
                    <li>
                      <a href="forms/forms.html">
                        <span class="sub-item">Schedule</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#vm">
                  <i class="fas fa-server"></i>
                  <p>VM</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="vm">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{ route('vms.index') }}">
                        <span class="sub-item">VM List</span>
                      </a>
                    </li>
                  
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#tables">
                  <i class="fas fa-table"></i>
                  <p>Tables</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="tables">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="tables/tables.html">
                        <span class="sub-item">Basic Table</span>
                      </a>
                    </li>
                    <li>
                      <a href="tables/datatables.html">
                        <span class="sub-item">Datatables</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-toggle="collapse" href="#base">
                    <i class="fas fa-layer-group"></i>
                    <p>Base</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                    <ul class="nav nav-collapse">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <span class="sub-item">Some Item</span>
                            </a>
                        </li>
                    </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->