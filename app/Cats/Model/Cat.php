<?php
/**
 * Created by PhpStorm.
 * User: iisac
 * Date: 10/11/19
 * Time: 12:55 PM
 */

namespace App\Cats\Model;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Cat
 * @package App\Cats\Model
 */
class Cat extends Model{

    const STATUS_HAPPY = 1;
    const STATUS_HUNGRY = 2;
    const STATUS_PLAYFUL = 3;

    const STATUS_TRANSLATIONS = [
        self::STATUS_HAPPY => 'happy',
        self::STATUS_HUNGRY => 'hungry',
        self::STATUS_PLAYFUL => 'playful',
    ];

    /**
     * @var string
     */
    protected $table = 'cats';

    /**
     * Reset cat food/new day :)
     */
    public function resetFood() : void {
        $this->food = 0;
    }
}
