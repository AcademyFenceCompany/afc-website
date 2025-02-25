<?php

namespace App\Console\Commands;

use App\Models\CategoryPage;
use App\Models\FamilyCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UpdateCategoryPageSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:update-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update slugs for all category pages';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pages = CategoryPage::with('category')->get();
        
        foreach ($pages as $page) {
            if ($page->category) {
                $page->slug = Str::slug($page->category->family_category_name);
                $page->save();
                $this->info("Updated slug for category page {$page->id} to: {$page->slug}");
            }
        }

        $this->info('All category page slugs have been updated.');
    }
}
