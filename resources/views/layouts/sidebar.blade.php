<style>
    /* CSS untuk animasi sidebar */
    .sidebar {
      transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
      position: fixed;
      z-index: 40;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .sidebar-collapsed {
      transform: translateX(-100%);
    }
    
    .content {
      transition: margin-left 0.3s ease-in-out;
    }
    
    .toggle-button {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background-color: rgba(0, 77, 153, 0.8);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      cursor: pointer;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
      transition: all 0.2s ease;
    }
    
    .toggle-button:hover {
      background-color: rgba(0, 61, 122, 1);
    }
    
    .menu-item {
      display: flex;
      align-items: center;
      padding: 0.5rem 0.75rem;
      border-radius: 0.25rem;
      transition: all 0.2s ease;
    }
    
    .menu-item:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
    
    .menu-item i {
      width: 18px;
      text-align: center;
    }
  </style>
<!-- Sidebar -->
<div id="sidebar" class="sidebar text-white w-40 flex flex-col h-screen" style="background-color: #0056b3;">
    <div class="flex justify-between items-center py-4 px-3 border-b border-blue-900" style="background-color: #003d7a;">
        <div class="flex items-center">
            <img src="asset/LogoPertamina.png" class="h-7">
        </div>
        <button id="toggleSidebar" class="toggle-button flex items-center justify-center">
            <i class="fas fa-chevron-left text-sm"></i>
        </button>
    </div>

    <!-- LIST MENU (Gunakan flex-grow agar profil terdorong ke bawah) -->
    <ul class="mt-2 space-y-0 flex-grow px-2">
        <li>
            <a href="{{ route('user.dashboard') }}" class="menu-item py-2">
                <i class="fas fa-ticket-alt text-white text-sm"></i>
                <span class="ml-2 text-sm font-medium">All Tickets</span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.open-ticket') }}" class="menu-item py-2">
                <i class="fas fa-folder-open text-white text-sm"></i>
                <span class="ml-2 text-sm font-medium">Open</span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.pending-ticket') }}" class="menu-item py-2">
                <i class="fas fa-clock text-white text-sm"></i>
                <span class="ml-2 text-sm font-medium">Pending</span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.solved-ticket') }}" class="menu-item py-2">
                <i class="fas fa-check text-white text-sm"></i>
                <span class="ml-2 text-sm font-medium">Solved</span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.report') }}" class="menu-item py-2">
                <i class="fas fa-chart-pie text-white text-sm"></i>
                <span class="ml-2 text-sm font-medium">Report</span>
            </a>
        </li>
    </ul>

    <!-- Tombol Logout dan profil -->
    <div class="mt-auto">
        <!-- Tombol Logout -->
        <div class="px-3 py-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-1 bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded transition duration-200 text-sm">
                    <i class="fas fa-sign-out-alt text-sm"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
        
        <!-- PROFIL -->
        <div class="flex items-center px-3 py-3 border-t border-blue-900" style="background-color: #003d7a;">
            <img class="rounded-full h-8 w-8 flex-shrink-0 border border-white" src="asset/user.png"/>
            <div class="ml-2 flex flex-col w-full overflow-hidden">
                <p class="text-xs font-semibold leading-tight truncate text-white">PT. Sejahtera Indonesia</p>
                <p class="text-xs text-blue-200 leading-tight truncate">sejahteracoorperation@gmail.com</p>
            </div>
        </div>
    </div>
</div>