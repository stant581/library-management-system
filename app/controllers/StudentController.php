<?php

class StudentController extends \BaseController {

	public function __construct(){

		$this->filter_params = array('branch','year','category');

	}

	public function index()
	{
		$conditions = array(
			'approved'	=> 0,
			'rejected'	=> 0
		);

		$students = Student::select('student_id', 'first_name', 'last_name', 'category', 'roll_num', 'branch', 'year')
			->where($conditions)
			->orderBy('student_id');

		$this->filterQuery($students);
		$students = $students->get();
    
        return $students;
	}


	public function create()
	{
		$conditions = array(
			'approved'	=> 1,
			'rejected'	=> 0
		);
		
		$students = Student::select('student_id', 'first_name', 'last_name', 'category', 'roll_num', 'branch', 'year', 'email_id', 'books_issued')
			->where($conditions)
			->orderBy('student_id');

		$this->filterQuery($students);
		$students = $students->get();
    
        return $students;
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
        $flag = (bool)Input::get('flag');
		
        $student = Student::findOrFail($id);
		
		if($flag){
			// if student is approved
	        $student->approved = 1;
		} else {
			// if student is rejected for some reason
			$student->rejected = 1;
		}
        
        $student->save();
    
        return "Student's approval/rejection status successfully changed.";
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	public function renderStudents(){
		$db_control = new HomeController;
		return View::make('panel.students')
			->with('branch_list', $db_control->branch_list)
			->with('student_categories_list', $db_control->student_categories_list);
	}

	public function renderApprovalStudents(){
		$db_control = new HomeController;
		return View::make('panel.approval')
			->with('branch_list', $db_control->branch_list)
			->with('student_categories_list', $db_control->student_categories_list);
	}


}
