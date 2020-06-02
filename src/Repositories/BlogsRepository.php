<?php namespace Bishopm\Blog\Repositories;

use Bishopm\Blog\Repositories\EloquentBaseRepository;

class BlogsRepository extends EloquentBaseRepository
{
    public function getTags($id)
    {
        $blogs=$this->model->where('user_id', $id)->where('status', 'Published')->get();
        $tags=array();
        foreach ($blogs as $blog) {
            foreach ($blog->tags as $tag) {
                $tags[$tag->slug]['name']=$tag->name;
                $tags[$tag->slug]['id']=$tag->id;
                $tags[$tag->slug]['slug']=$tag->slug;
                if (array_key_exists('count', $tags[$tag->slug])) {
                    $tags[$tag->slug]['count']++;
                } else {
                    $tags[$tag->slug]['count']=1;
                }
            }
        }
        ksort($tags);
        return $tags;
    }

    public function allForBlogger($id, $take)
    {
        return $this->model->where('user_id', $id)->where('status', 'Published')->orderBy('created_at', 'DESC')->paginate($take);
    }

    public function search($id, $search)
    {
        return $this->model->where(function ($query) use ($id,$search) {
            $query->where('user_id', $id)
                  ->where('status', 'Published')
                  ->where('title', 'like', '%' . $search . '%');
        })
        ->orWhere(function ($query) use ($id,$search) {
            $query->where('user_id', $id)
                  ->where('status', 'Published')
                  ->where('body', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'DESC')->get();
    }
}
