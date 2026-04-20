<?php

use Illuminate\Support\Facades\Route;
use Acme\CmsDashboard\Http\Controllers\Admin\PostController;
use Acme\CmsDashboard\Http\Controllers\Admin\PostTypeController;
use Acme\CmsDashboard\Http\Controllers\Admin\MediaController;
use Acme\CmsDashboard\Http\Controllers\Admin\DashboardController;
use Acme\CmsDashboard\Http\Controllers\Admin\CustomFieldController;

Route::prefix('admin')->name('admin.')->middleware(['web'])->group(function () {
    Route::get('edit-post', [PostController::class, 'edit'])->name('edit-post');
    Route::post('posts/bulk', [PostController::class, 'bulk'])->name('posts.bulk');
    Route::post('categories/bulk', [\Acme\CmsDashboard\Http\Controllers\Admin\CategoryController::class, 'bulk'])->name('categories.bulk');
    Route::post('tags/bulk', [\Acme\CmsDashboard\Http\Controllers\Admin\TagController::class, 'bulk'])->name('tags.bulk');
    Route::post('posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore')->withTrashed();
    Route::delete('posts/{post}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete')->withTrashed();
    Route::resource('posts', PostController::class);
    Route::get('builder/{id}', [PostController::class, 'builder'])->name('builder');
    Route::post('builder/{id}/save', [PostController::class, 'saveBuilder'])->name('builder.save');
    Route::get('builder/{id}/preview', [PostController::class, 'previewBuilder'])->name('builder.preview');

    Route::post('pages/bulk', [\Acme\CmsDashboard\Http\Controllers\Admin\PageController::class, 'bulk'])->name('pages.bulk');
    Route::post('pages/{page}/restore', [\Acme\CmsDashboard\Http\Controllers\Admin\PageController::class, 'restore'])->name('pages.restore')->withTrashed();
    Route::delete('pages/{page}/force-delete', [\Acme\CmsDashboard\Http\Controllers\Admin\PageController::class, 'forceDelete'])->name('pages.force-delete')->withTrashed();
    Route::resource('pages', \Acme\CmsDashboard\Http\Controllers\Admin\PageController::class);
    Route::resource('categories', \Acme\CmsDashboard\Http\Controllers\Admin\CategoryController::class);
    Route::resource('tags', \Acme\CmsDashboard\Http\Controllers\Admin\TagController::class);
    Route::resource('post-types', PostTypeController::class)->only(['index', 'store', 'destroy']);
    
    Route::post('categories/ajax', function(\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'parent_id' => 'nullable|exists:categories,id'
        ]);
        $category = \Acme\CmsDashboard\Models\Category::firstOrCreate(
            ['slug' => \Illuminate\Support\Str::slug($validated['name'])],
            [
                'name' => $validated['name'],
                'parent_id' => $validated['parent_id'] ?? null
            ]
        );
        return response()->json($category);
    })->name('categories.ajax');
    // Navigation Menus
    Route::resource('menus', \Acme\CmsDashboard\Http\Controllers\Admin\MenuManagementController::class);
    
    // ACPT Routes
    Route::prefix('acpt')->name('acpt.')->group(function () {
        Route::get('cpt', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpCptController::class, 'index'])->name('cpt.index');
        Route::get('cpt/create', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpCptController::class, 'create'])->name('cpt.create');
        Route::post('cpt/store', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpCptController::class, 'store'])->name('cpt.store');
        
        Route::post('cpt/bulk', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpCptController::class, 'bulk'])->name('cpt.bulk');
        
        Route::get('cpt/{id}/edit', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpCptController::class, 'edit'])->name('cpt.edit');
        Route::put('cpt/{id}', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpCptController::class, 'update'])->name('cpt.update');
        Route::delete('cpt/{id}', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpCptController::class, 'destroy'])->name('cpt.destroy');
        Route::post('cpt/{id}/duplicate', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpCptController::class, 'duplicate'])->name('cpt.duplicate');
        Route::post('cpt/{id}/toggle-status', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpCptController::class, 'toggleStatus'])->name('cpt.toggle-status');
        Route::get('taxonomies', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpTaxonomyController::class, 'index'])->name('taxonomies.index');
        Route::get('taxonomies/create', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpTaxonomyController::class, 'create'])->name('taxonomies.create');
        Route::post('taxonomies/store', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpTaxonomyController::class, 'store'])->name('taxonomies.store');
        Route::post('taxonomies/bulk', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpTaxonomyController::class, 'bulk'])->name('taxonomies.bulk');
        Route::get('taxonomies/{slug}/edit', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpTaxonomyController::class, 'edit'])->name('taxonomies.edit');
        Route::put('taxonomies/{slug}', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpTaxonomyController::class, 'update'])->name('taxonomies.update');
        Route::delete('taxonomies/{slug}', [\Acme\CmsDashboard\Http\Controllers\Admin\ActpTaxonomyController::class, 'destroy'])->name('taxonomies.destroy');

        // ACPT Fields
        Route::resource('fields', CustomFieldController::class);
        Route::post('fields/store-field', [CustomFieldController::class, 'storeField'])->name('fields.store_field');
        Route::delete('fields/delete-field/{field}', [CustomFieldController::class, 'deleteField'])->name('fields.delete_field');

        // Taxonomy Terms
        Route::get('taxonomies/{slug}/terms', [\Acme\CmsDashboard\Http\Controllers\Admin\TaxonomyTermController::class, 'index'])->name('terms.index');
        Route::post('taxonomies/{slug}/terms', [\Acme\CmsDashboard\Http\Controllers\Admin\TaxonomyTermController::class, 'store'])->name('terms.store');
        Route::post('taxonomies/terms/ajax', [\Acme\CmsDashboard\Http\Controllers\Admin\TaxonomyTermController::class, 'ajaxStore'])->name('terms.ajax');
        Route::delete('taxonomies/{slug}/terms/{id}', [\Acme\CmsDashboard\Http\Controllers\Admin\TaxonomyTermController::class, 'destroy'])->name('terms.destroy');
        Route::post('taxonomies/{slug}/terms/bulk', [\Acme\CmsDashboard\Http\Controllers\Admin\TaxonomyTermController::class, 'bulk'])->name('terms.bulk');

    });
    
    // Dashboard index
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // Media routes
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::get('media/upload', [MediaController::class, 'create'])->name('media.create');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::put('media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

    Route::get('fix-db', function() {
        try {
            // Run standard migrations
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'Acme\\CmsDashboard\\Database\\Seeders\\MenuSeeder', 
                '--force' => true
            ]);
            
            // 1. Remove Dummy 'Pages' if it has no children and has route '#'
            // Actually, the user says remove the one AFTER Media.
            // Let's just consolidate Page menus.
            $pagesMenus = \Acme\CmsDashboard\Models\Menu::where('title', 'Pages')->get();
            if ($pagesMenus->count() > 1) {
                // Keep the one that has children or a working route
                foreach($pagesMenus as $m) {
                    if ($m->route === '#' && $m->children->isEmpty()) {
                        $m->delete();
                    }
                }
            }

            // 2. Ensure we have a working Pages menu if somehow it was deleted or missing
            $pagesMenu = \Acme\CmsDashboard\Models\Menu::where('title', 'Pages')->first();
            if (!$pagesMenu) {
                $pagesMenu = \Acme\CmsDashboard\Models\Menu::create([
                    'title' => 'Pages',
                    'route' => 'admin.pages.index',
                    'icon'  => '<svg class="w-full h-full" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>',
                    'group' => 'Main',
                    'order' => 25, // Between Posts (20) and Media (30)
                ]);
            }

            // 3. Ensure sub-menus for Pages
            if ($pagesMenu && $pagesMenu->children->isEmpty()) {
                $pagesMenu->children()->createMany([
                    ['title' => 'All Pages', 'route' => 'admin.pages.index', 'order' => 1],
                    ['title' => 'Add New',  'route' => 'admin.pages.create', 'order' => 2],
                ]);
            }

            // 4. Force order
            \Illuminate\Support\Facades\DB::table('menus')->where('title', 'Dashboard')->update(['order' => 10]);
            \Illuminate\Support\Facades\DB::table('menus')->where('title', 'Posts')->update(['order' => 20]);
            \Illuminate\Support\Facades\DB::table('menus')->where('title', 'Pages')->update(['order' => 25]);
            \Illuminate\Support\Facades\DB::table('menus')->where('title', 'Media')->update(['order' => 30]);
            \Illuminate\Support\Facades\DB::table('menus')->where('title', 'Comments')->update(['order' => 40]);
            
            // Ensure published_at exists
            if (!\Illuminate\Support\Facades\Schema::hasColumn('posts', 'published_at')) {
                \Illuminate\Support\Facades\Schema::table('posts', function ($table) {
                    $table->timestamp('published_at')->nullable();
                });
            }

            // 5. Ensure ACPT and Custom Fields are seeded (Clean duplicates)
            $acptMenu = \Acme\CmsDashboard\Models\Menu::where('title', 'ACPT')->first();
            if (!$acptMenu) {
                $acptMenu = \Acme\CmsDashboard\Models\Menu::create([
                    'title' => 'ACPT',
                    'route' => 'admin.acpt.cpt.index',
                    'icon'  => '<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>',
                    'group' => 'Advanced',
                    'order' => 100,
                ]);
            }

            // Update Post/Page UI to use unified admin/posts/create?type=...
            $postMenu = DB::table('menus')->where('title', 'Posts')->whereNull('parent_id')->first();
            if ($postMenu) {
                // Delete "Add New" if "Add Post" exists, or just ensure one clean item
                DB::table('menus')->where('parent_id', $postMenu->id)->where('title', 'Add New')->delete();
                
                DB::table('menus')->updateOrInsert(
                    ['parent_id' => $postMenu->id, 'title' => 'Add Post'],
                    [
                        'route' => '/admin/posts/create?type=post',
                        'icon' => '<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>',
                        'order' => 1
                    ]
                );
            }

            $pageMenu = DB::table('menus')->where('title', 'Pages')->whereNull('parent_id')->first();
            if ($pageMenu) {
                // Remove redundant submenus
                DB::table('menus')->where('parent_id', $pageMenu->id)->where('title', 'Add New')->delete();

                // Update All Pages link to list view in Posts controller with type=page
                DB::table('menus')->where('id', $pageMenu->id)->update(['route' => '/admin/posts?type=page']);
                
                DB::table('menus')->updateOrInsert(
                    ['parent_id' => $pageMenu->id, 'title' => 'All Pages'],
                    ['route' => '/admin/posts?type=page', 'order' => 0]
                );

                DB::table('menus')->updateOrInsert(
                    ['parent_id' => $pageMenu->id, 'title' => 'Add Page'],
                    [
                        'route' => '/admin/posts/create?type=page',
                        'icon' => '<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>',
                        'order' => 1
                    ]
                );
            }

            if ($acptMenu) {
                // Delete all existing children first to avoid duplicates
                \Acme\CmsDashboard\Models\Menu::where('parent_id', $acptMenu->id)->delete();
                
                // Re-create them fresh
                $acptSubMenus = [
                    ['title' => 'Post Types',   'route' => 'admin.acpt.cpt.index',       'order' => 1],
                    ['title' => 'Taxonomies',   'route' => 'admin.acpt.taxonomies.index', 'order' => 2],
                    ['title' => 'Custom Fields', 'route' => 'admin.acpt.fields.index',    'order' => 3],
                ];
                foreach ($acptSubMenus as $sub) {
                    \Acme\CmsDashboard\Models\Menu::create([
                        'parent_id' => $acptMenu->id,
                        'title' => $sub['title'],
                        'route' => $sub['route'],
                        'order' => $sub['order']
                    ]);
                }
            }
    // Sync all existing active taxonomies
            if (class_exists(\Acme\CmsDashboard\Models\CustomTaxonomy::class)) {
                $taxController = new \Acme\CmsDashboard\Http\Controllers\Admin\ActpTaxonomyController();
                $allTaxonomies = \Acme\CmsDashboard\Models\CustomTaxonomy::where('is_active', true)->get();
                foreach ($allTaxonomies as $taxonomy) {
                    $taxController->syncTaxonomyMenus($taxonomy);
                }
            }

            return "Database fixed! Redundant Pages removed and sidebar re-ordered. <br><br> <a href='".route('admin.pages.index')."'>Go to Dashboard</a>";
        } catch (\Exception $e) {
            return "Error fixing DB: " . $e->getMessage();
        }
    })->name('fix-db');
});

// Frontend Routes
use Acme\CmsDashboard\Http\Controllers\FrontendController;
Route::middleware(['web'])->group(function () {
    Route::get('{type}/{slug}', [FrontendController::class, 'show'])->name('posts.show.typed');
    Route::get('{slug}', [FrontendController::class, 'show'])->name('posts.show');
});
