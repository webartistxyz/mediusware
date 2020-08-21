<?php

namespace Bulkly\Http\Controllers;

use Bulkly\History;
use App\SearchData\Search;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function getAllGroup()
    {
        return DB::table('social_post_groups')->get();
    }



    public function bufferPosts(Request $request)
    {
        $searchData = $request->search_term;
        $order_by = $request->order_by;
        $sort_by = $request->sort_by;
        $columns = [
            'buffer_postings.sent_at', 'buffer_postings.post_text',
            'social_post_groups.name', 'social_post_groups.type', 'users.timezone', 'users.name'
        ];

        $query = DB::table('buffer_postings')
            ->leftJoin('social_post_groups', 'buffer_postings.group_id', '=', 'social_post_groups.id')
            ->leftJoin('users', 'buffer_postings.user_id', '=', 'users.id')
            ->select(
                'buffer_postings.sent_at',
                'buffer_postings.post_text',
                'social_post_groups.name AS group_name',
                'social_post_groups.type AS group_type',
                'users.timezone AS timezone',
                'users.name AS user_name'
            );
        Search::searchQuery($query, $columns, $searchData);
        $query->orderByRaw('' . $sort_by . ' ' . $order_by . '');
        $data = $query->paginate($request->per_page);

        return $data;
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Bulkly\History  $history
     * @return \Illuminate\Http\Response
     */
    public function show(History $history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Bulkly\History  $history
     * @return \Illuminate\Http\Response
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Bulkly\History  $history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Bulkly\History  $history
     * @return \Illuminate\Http\Response
     */
    public function destroy(History $history)
    {
        //
    }
}
