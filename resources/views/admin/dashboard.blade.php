<x-cms-dashboard::layouts.admin>
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-[#2271b1] to-[#135e96] rounded-sm p-8 mb-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl font-light mb-2">Welcome to your Dashboard, {{ auth()->user()->name ?? 'Admin' }}!</h1>
                <p class="text-blue-100 text-lg opacity-90">Manage your site content, media, and track your performance from one central hub.</p>
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.posts.create') }}" class="bg-white text-[#2271b1] px-4 py-2 rounded-sm text-sm font-medium hover:bg-blue-50 transition-colors">Write your first post</a>
                    <a href="{{ route('admin.pages.create') }}" class="bg-transparent border border-white/30 text-white px-4 py-2 rounded-sm text-sm font-medium hover:bg-white/10 transition-colors">Add a new page</a>
                </div>
            </div>
            <!-- Decorative SVG circles -->
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-white/5 rounded-full blur-2xl"></div>
        </div>

        <!-- Quick Stats Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Hits -->
            <div class="bg-white p-6 border border-[#c3c4c7] rounded-sm shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-lg text-[#2271b1]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-[#646970] uppercase tracking-wider">Total Site Hits</p>
                        <h3 class="text-3xl font-bold text-[#1d2327]">{{ number_format($stats['total_hits']) }}</h3>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-green-600 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/></svg>
                    <span>12.5% increase from last month</span>
                </div>
            </div>

            <!-- Active Visitors -->
            <div class="bg-white p-6 border border-[#c3c4c7] rounded-sm shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-50 rounded-lg text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-[#646970] uppercase tracking-wider">Current Visitors</p>
                        <h3 class="text-3xl font-bold text-[#1d2327] flex items-center">
                            {{ $stats['active_visitors'] }}
                            <span class="flex h-3 w-3 ml-3 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                        </h3>
                    </div>
                </div>
                <p class="mt-4 text-xs text-[#646970]">Active users currently browsing your site</p>
            </div>

            <!-- Content Overview -->
            <div class="bg-white p-6 border border-[#c3c4c7] rounded-sm shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-purple-50 rounded-lg text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-[#646970] uppercase tracking-wider">Content Summary</p>
                        <div class="flex gap-4 mt-1">
                            <span class="text-lg font-bold text-[#1d2327]">{{ $stats['counts']['posts'] }} <small class="text-[10px] text-[#646970] font-normal uppercase">Posts</small></span>
                            <span class="text-lg font-bold text-[#1d2327]">{{ $stats['counts']['pages'] }} <small class="text-[10px] text-[#646970] font-normal uppercase">Pages</small></span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="{{ route('admin.posts.index') }}" class="text-[11px] text-[#2271b1] hover:underline">Manage All</a>
                </div>
            </div>
        </div>

        <!-- Details Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Top Pages Widget -->
            <div class="bg-white border border-[#c3c4c7] rounded-sm shadow-sm">
                <div class="px-6 py-4 border-b border-[#f0f0f1] flex justify-between items-center bg-[#f9fafb]">
                    <h2 class="text-md font-bold text-[#1d2327]">Most Viewed Pages</h2>
                    <span class="text-[10px] font-bold text-[#646970] uppercase px-2 py-0.5 bg-gray-100 rounded">Live Tracking</span>
                </div>
                <div class="p-0">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 text-[#646970] uppercase text-[11px] font-bold">
                            <tr>
                                <th class="px-6 py-3">Page Title</th>
                                <th class="px-6 py-3 text-right">Unique Views</th>
                                <th class="px-6 py-3">Retention</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f0f0f1]">
                            @foreach($stats['top_pages'] as $page)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-[#2271b1] hover:underline cursor-pointer">{{ $page['title'] }}</td>
                                <td class="px-6 py-4 text-right font-mono">{{ number_format($page['views']) }}</td>
                                <td class="px-6 py-4">
                                    <div class="w-24 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-500" style="width: {{ rand(40, 95) }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 border-t border-[#f0f0f1] text-center">
                    <a href="#" class="text-[12px] text-[#2271b1] hover:underline font-medium">View full analytics report</a>
                </div>
            </div>

            <!-- Recent Activity / News (Placeholder) -->
            <div class="bg-white border border-[#c3c4c7] rounded-sm shadow-sm">
                <div class="px-6 py-4 border-b border-[#f0f0f1] flex justify-between items-center bg-[#f9fafb]">
                    <h2 class="text-md font-bold text-[#1d2327]">Quick Draft</h2>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <input type="text" placeholder="Title" class="wp-input w-full text-[14px]">
                    </div>
                    <div class="mb-4">
                        <textarea placeholder="What's on your mind?" class="wp-input w-full h-32 text-[13px]"></textarea>
                    </div>
                    <button class="wp-btn-secondary px-6">Save Draft</button>
                    
                    <div class="mt-8 pt-6 border-t border-[#f0f0f1]">
                        <h4 class="text-xs font-bold text-[#646970] uppercase mb-3 px-1">At a Glance</h4>
                        <div class="space-y-2 px-1">
                            <div class="flex items-center text-[13px] text-[#1d2327] gap-2">
                                <svg class="w-4 h-4 text-[#646970]" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/></svg>
                                <span>PHP Version: 8.2.3</span>
                            </div>
                            <div class="flex items-center text-[13px] text-[#1d2327] gap-2">
                                <svg class="w-4 h-4 text-[#646970]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L9.03 9.145a2.5 2.5 0 003.94 0l6.864-4.245A1 1 0 0019 3H5a1 1 0 00-.834 1.9zM19 7l-6.864 4.245a4.5 4.5 0 01-7.272 0L2 7v7a2 2 0 002 2h12a2 2 0 002-2V7z" clip-rule="evenodd"/></svg>
                                <span>Storage: 45GB / 100GB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-cms-dashboard::layouts.admin>
