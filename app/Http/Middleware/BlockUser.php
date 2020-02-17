<?php

namespace FDA\Http\Middleware;

use Closure;
use FDA\Block;
use Illuminate\Support\Facades\URL;

class BlockUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $bP = URL::current(); // get current url
        $appCatId = $request->appointment_category_id;
        $blockUser = Block::select("block_to")
                    ->where([['user_id', \auth()->user()->id], ['appointment_category_id', $appCatId]])
                    ->orderBy('block_to', "desc")
                    ->first();
                    // dd(auth()->user()->id);
            if($blockUser){
                // dd($blockUser);
                $endDate = strtotime($blockUser->block_to);
                $toDay = strtotime(today());
                if ($endDate>=$toDay) {
                    return redirect("/")->with('warning', 'You are not currently available this appointment type.');
                }
            }
        return $next($request);
    }
}
