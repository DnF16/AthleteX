<div class="list-group rounded-0 h-100 shadow-sm" style="border: 1px solid #c4d79b;">
    <div class="list-group-item border-0 fw-bold text-uppercase text-white text-center py-3" 
         style="background-color: #2e4e1f; border-radius: 0; font-size: 0.95rem;">
        Admin Menu
    </div>

    @php
        $admin_links = [
            'general' => ['name' => 'General Information', 'icon' => 'fas fa-info-circle'],
            'settings' => ['name' => 'Application Settings', 'icon' => 'fas fa-sliders-h'],
            'users' => ['name' => 'Users & Security', 'icon' => 'fas fa-user-shield'],
            'classes' => ['name' => 'Classes & Lessons', 'icon' => 'fas fa-book'],
            'scheduling' => ['name' => 'Scheduling Settings', 'icon' => 'fas fa-clock'],
            'certificates' => ['name' => 'Certificates & Awards', 'icon' => 'fas fa-award'],
            'grades' => ['name' => 'Grades & Scoring', 'icon' => 'fas fa-star'],
            'transactions' => ['name' => 'Transactions', 'icon' => 'fas fa-money-check'],
        ];
    @endphp

    @foreach($admin_links as $route_name => $link)
    <a href="{{ route('admin.' . $route_name) }}" 
       class="list-group-item list-group-item-action border-0 py-2 fw-semibold border-start ps-3 
       {{ request()->routeIs('admin.' . $route_name) ? 'bg-light text-success border-success' : 'bg-transparent text-secondary border-transparent' }}"
       style="border-bottom: 1px solid #eee; font-size: 0.9rem; transition: all 0.15s;">
       <i class="{{ $link['icon'] }} me-2" style="width: 20px; text-align: center;"></i> {{ $link['name'] }}
    </a>
    @endforeach
</div>