<?php

namespace FDA\Filters;
use FDA\User;

class BlockFilter extends Filters
{

	/**
	 * Register filter properties
	 */
	protected $filters = [
		'company_registration_no'
	];

	/**
	 * Filter by company registration no.
	 */
	public function company_registration_no($value) 
	{
		$user = User::where('company_registration_no',$value)->first();

		return $this->builder->where('user_id',optional($user)->id);
	}

}