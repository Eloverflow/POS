<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Employee extends Model
{
    use Searchable;

    protected $fillable = ['firstName', 'lastName', 'streetAddress', 'phone', 'city', 'state', 'pc', 'nas','userId', 'password', 'salt', 'bonusSalary', 'birthDate', 'hireDate' ];

    public static function getById($id)
    {
        return \DB::table('employees')
            ->join('users', 'employees.userId', '=', 'users.id')
            ->select(\DB::raw('employees.id as idEmployee, users.id as idUser, employees.bonusSalary, streetAddress, phone, firstName, lastName, city, nas, pc, state, birthDate, hireDate, email, hireDate'))
            ->where('employees.id', '=', $id)
            ->first();
    }

    public static function getAll()
    {
        return \DB::select('SELECT * FROM (
                                SELECT  a.id as idEmployee, a.firstName, a.lastName, u.email, a.hireDate, c.startTime, c.endTime
                            FROM employees a
                                LEFT OUTER JOIN users u
                                    ON a.userId = u.id
                                LEFT OUTER JOIN punches c
                                    ON a.id = c.employee_id
                                LEFT OUTER JOIN
                                (
                                    SELECT employee_id, MAX(startTime) maxDate
                                    FROM punches
                                    GROUP BY employee_id
                                ) b ON c.employee_id = b.employee_id AND
                                        c.startTime = b.maxDate
                                order by c.startTime desc
                            ) AS tmp_table GROUP BY idEmployee');
    }


    public function user()
    {
        return $this->hasOne('App\Models\Auth\User', 'id', 'userId');
    }
}
