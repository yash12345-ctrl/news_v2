<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\ArticleVote;
use App\Models\ArticleComment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class DeleteArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all the articles upto a given date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! $this->confirm("Do you really want to delete articles?")) {
            return;
        }
        $dry_run = $this->confirm("Dry run?");
        $success_count = 0;
        $failure_count = 0;
        $issues = [];
        $missing_file_count = 0;
        $missing_file_articles = [];
        $vote_delete_count = 0;
        $comment_delete_count = 0;
        $processed = 0;
        $chunk_per_loop = 500;
        $date = "2025-08-31 23:59:59";
        $last_article = Article::where("created_at", "<=", $date)
            ->orderBy('id', 'desc')
            ->first();
        Article::where("created_at", "<=", $date)
            ->orderBy('id', 'desc')
            ->chunk($chunk_per_loop, function(Collection $articles) use (&$success_count, &$failure_count, &$issues, &$missing_file_articles, &$missing_file_count, &$processed, $chunk_per_loop, $dry_run) {
                foreach ($articles as $a) {
                    if ($a->image_url) {
                        $image_filepath = $this->getImageFilepathFromUrl($a->image_url);
                        if (file_exists($image_filepath)) {
                            if (! $dry_run) {
                                unlink($image_filepath);
                            }
                        } else {
                            $missing_file_count++;
                            $missing_file_articles[] = $a;
                        }
                    }
                    if ($a->image_sm_url) {
                        $image_sm_filepath = $this->getImageFilepathFromUrl($a->image_sm_url);
                        if (file_exists($image_sm_filepath)) {
                            if (! $dry_run) {
                                unlink($image_sm_filepath);
                            }
                        } else {
                            $missing_file_count++;
                            $missing_file_articles[] = $a;
                        }
                    }

                    if ($a->image_url && $a->image_sm_url) {
                        $success_count++;
                    } else {
                        $issues[] = $a;
                        $failure_count++;
                    }
                    $processed += 1;
                }
                $this->info("$processed articles processed.");
            });

        foreach ($issues as $a) {
            Log::warning("delete-article-issue: id: $a->id   image_url: $a->image_url  image_sm_url: $a->image_sm_url");
        }
        foreach ($missing_file_articles as $a) {
            Log::warning("delete-article-issue: missing-file: id: $a->id   image_url: $a->image_url  image_sm_url: $a->image_sm_url");
        }
        if ($last_article) {
            if ($dry_run) {                
                $vote_delete_count = ArticleVote::where("article_id", "<=", $last_article->id)->count();
                $comment_delete_count = ArticleComment::where("article_id", "<=", $last_article->id)->count();
            } else {
                $vote_delete_count = ArticleVote::where("article_id", "<=", $last_article->id)->delete();
                $comment_delete_count = ArticleComment::where("article_id", "<=", $last_article->id)->delete();
            }
        }
        if ($dry_run) {
            $delete_count = Article::where("created_at", "<=", $date)->count();
        } else {
            $delete_count = Article::where("created_at", "<=", $date)->delete();
        }

        $this->info("               Total = $processed");
        $this->info("             Success = $success_count");
        $this->info("             Failure = $failure_count");
        $this->info("  Missing file count = $missing_file_count");
        $this->info("   Vote delete count = $vote_delete_count");
        $this->info("Comment delete count = $vote_delete_count");
        $this->info("             Deleted = $delete_count");
    }

    private function getImageFilepathFromUrl(string $url): string
    {
        if (! $url) {
            return "";
        }

        $filename = substr($url, strrpos($url, "/"));

        return public_path("uploads$filename");
    }
}
