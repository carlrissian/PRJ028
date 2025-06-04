<?php
declare(strict_types=1);


namespace Distribution\Acriss\Domain;


/**
 * Class AcrissNameValueObject
 * @package Distribution\Acriss\Domain
 */
class AcrissNameValueObject
{
    /**
     * @var array
     */
    public static array $FIRST_ACRISS_LETTER_LIST = ['M', 'N', 'E', 'H', 'C', 'D', 'I', 'J', 'S', 'R', 'F', 'G', 'P', 'U', 'L', 'W', 'O', 'X'];
    public static array $FIRST_ACRISS_LETTER_NAMES = ['Mini', 'Mini Elite', 'Economy', 'Economy Elite', 'Compact', 'Compact Elite', 'Intermediate', 'Intermediate Elite', 'Standard', 'Standard Elite', 'Fullsize', 'Fullsize Elite', 'Premium', 'Premium Elite', 'Luxury', 'Luxury Elite', 'Oversize', 'Special'];

    /**
     * @var array
     */
    public static array $SECOND_ACRISS_LETTER_LIST = ['B', 'C', 'D', 'W', 'V', 'L', 'S', 'T', 'F', 'J', 'X', 'P', 'Q', 'Z', 'E', 'M', 'R', 'H', 'Y', 'N', 'G', 'K'];
    public static array $SECOND_ACRISS_LETTER_NAMES = ['2-3 Door', '2/4 Door', '4-5 Door', 'Wagon/Estate', 'Passenger Van',
        'Limousine/Sedan', 'Sport', 'Convertible', 'SUV', 'Open Air All Terrain', 'Special', 'Pick up (single/extended cab) 2 door',
        'Pick up(double cab) 4 door', 'Special Offer Car', 'Coupe', 'Monospace', 'Recreational Vehicle', 'Motor Home',
        '2 Wheel Vehicle', 'Roadster', 'Crossover', 'Commercial Van/Truck' ];

    /**
     * @var array
     */
    public static array $THIRD_ACRISS_LETTER_LIST = ['M', 'A'];
    public static array $THIRD_ACRISS_LETTER_NAMES = ['Manual', 'Automático'];

    /**
     * @var array
     */
    public static array $FOURTH_ACRISS_LETTER_LIST = ['R', 'D', 'Q', 'H', 'I', 'E', 'C', 'L', 'S', 'A', 'B', 'M', 'F', 'V', 'Z', 'U', 'X'];
    public static array $FOURTH_ACRISS_LETTER_NAMES = ['Unspecified', 'Diesel Air', 'Diesel No Air', 'Hybrid Air', 'Hybrid Plug in Air',
        'Electric (Distance < 250mi/400km) Air', 'Electric Plus (Distance >= 250mi/400km) Air', 'LGP/Compressed Gas Air', 'LGP/Compressed Gas No Air',
        'Hydrogen Air', 'Hydrogen No Air', 'Multi Fuel/Power Air', 'Multi Fuel/Power No Air', 'Petrol Air', 'Petrol No Air', 'Ethanol Air', 'Ethanol No Air'];

    /**
     * @var string
     */
    private string $acriss1;
    /**
     * @var string
     */
    private string $acriss2;
    /**
     * @var string
     */
    private string $acriss3;
    /**
     * @var string
     */
    private string $acriss4;

    /**
     * AcrissNameValueObject constructor.
     * @param string $acriss1
     * @param string $acriss2
     * @param string $acriss3
     * @param string $acriss4
     */
    public function __construct(string $acriss1, string $acriss2, string $acriss3, string $acriss4)
    {
        $this->acriss1 = $acriss1;
        $this->acriss2 = $acriss2;
        $this->acriss3 = $acriss3;
        $this->acriss4 = $acriss4;
    }

    /**
     * @param string $acriss1
     * @param string $acriss2
     * @param string $acriss3
     * @param string $acriss4
     * @throws InvalidAcrissException
     * @return AcrissNameValueObject
     */
    public static function create(string $acriss1, string $acriss2, string $acriss3, string $acriss4){

        /*if(!in_array($acriss1, self::$FIRST_ACRISS_LETTER_LIST)){
            throw new InvalidAcrissException('El acriss 1 no tiene una letra valida');
        }
        if(!in_array($acriss2, self::$SECOND_ACRISS_LETTER_LIST)){
            throw new InvalidAcrissException('El acriss 2 no tiene una letra valida');
        }
        if(!in_array($acriss3, self::$THIRD_ACRISS_LETTER_LIST)){
            throw new InvalidAcrissException('El acriss 3 no tiene una letra valida');
        }
        if(!in_array($acriss4, self::$FOURTH_ACRISS_LETTER_LIST)){
            throw new InvalidAcrissException('El acriss 4 no tiene una letra valida');
        }*/

        return new self ($acriss1, $acriss2, $acriss3, $acriss4);
    }

    /**
     * @param string $name
     * @return AcrissNameValueObject
     * @throws InvalidAcrissException
     */
    public static function createByName(string $name){

        /*if(!preg_match('/^[A-Z]{4}$/', $name)){
            throw new InvalidAcrissException('El acriss no tiene 4 digitos'.$name);
        }*/

        $acriss = str_split($name);

        return self::create($acriss[0], $acriss[1], $acriss[2], $acriss[3]);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->acriss1.$this->acriss2.$this->acriss3.$this->acriss4;
    }

    /**
     * @return string
     */
    public function getAcriss1(): string
    {
        return $this->acriss1;
    }

    /**
     * @return string
     */
    public function getAcriss2(): string
    {
        return $this->acriss2;
    }

    /**
     * @return string
     */
    public function getAcriss3(): string
    {
        return $this->acriss3;
    }

    /**
     * @return string
     */
    public function getAcriss4(): string
    {
        return $this->acriss4;
    }
}