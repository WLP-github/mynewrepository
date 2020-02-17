<?php

namespace FDA\Http\Controllers\Admin;

use FDA\Block;
use Illuminate\Http\Request;
use FDA\Http\Controllers\Controller;
use FDA\Filters\BlockFilter;
use FDA\User;
use Carbon\Carbon;
use FDA\Http\Requests\BlockRequest;
use FDA\AppointmentCategory;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlockFilter $filter)
    {   
        if(auth()->user()->role_id === 1){

            $blocks = Block::with(["appointmentCategory"])->filter($filter)->orderBy('id','desc')->paginate(25);

        }else{

            $blocks = Block::with(["appointmentCategory"])->filter($filter)->where('appointment_category_id', auth()->user()->department->id)->orderBy('id','desc')->paginate(25);

        }
    
        return view('admin.blocks.index',compact('blocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('id','company_name','company_registration_no')->where('role',99)->get();

        if(auth()->user()->role_id == 1)
            $appointmentCategories = AppointmentCategory::all();
        else
            $appointmentCategories = AppointmentCategory::where([
                ['department_id', auth()->user()->department_id]
            ])
                ->get();
        return view('admin.blocks.create',compact('users','appointmentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockRequest $request)
    {
        $data = $request->validated();

        $data['block_from'] = Carbon::createFromFormat('d/m/Y',$request->block_from);
        $data['block_to'] = Carbon::createFromFormat('d/m/Y',$request->block_to);

        $data['blocked_by'] = auth()->user()->id;

        Block::create($data);

        return redirect()->route('admin.blocks.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \FDA\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function show(Block $block)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \FDA\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        $appointmentCategories = AppointmentCategory::all();
        return view('admin.blocks.edit',compact('block','appointmentCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \FDA\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Block $block)
    {
        $data['block_from'] = Carbon::createFromFormat('d/m/Y',$request->block_from);
        $data['block_to'] = Carbon::createFromFormat('d/m/Y',$request->block_to);

        $data['appointment_category_id'] = $request->appointment_category_id;

        $block->update($data);

        return redirect()->route('admin.blocks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \FDA\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        $block->delete();
        return redirect()->route('admin.blocks.index');
    }
}
