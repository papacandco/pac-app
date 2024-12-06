<?php

namespace App\Controllers\Traits;

use Illuminate\Support\Facades\DB;

trait BuildStatTrait
{
    /**
     * List of available month
     *
     * @var array
     */
    protected $month = [
        'Jan',
        'Fev',
        'Mrs',
        'Avr',
        'Mai',
        'Jui',
        'Jul',
        'Aut',
        'Sept',
        'Oct',
        'Nov',
        'Dec',
    ];

    /**
     * List of available day
     *
     * @var array
     */
    protected $day = [
        'Lun',
        'Mar',
        'Mer',
        'Jeu',
        'Ven',
        'Sam',
        'Dim',
    ];

    /**
     * Build the bar chart
     *
     * @param  string|null  $method
     * @return array
     */
    public function buildBarChart(array $models, $method = 'month')
    {
        if (! in_array($method, ['day', 'month'])) {
            throw new \Exception('The method '.$method.' is not define.');
        }

        $data = [];

        foreach ($this->$method as $index => $item) {
            $data[$index] = [
                $method => $this->$method[$index],
            ];

            foreach ($models as $key => $model) {
                $data[$index]['x'.($key + 1)] = 0;
            }
        }

        foreach ($models as $index => $model) {
            $sql = 'count(id) as number_'.$index.', '.$method.'(created_at) as `'.$method.'`';
            $stats = (new $model)
                ->select(DB::raw($sql))
                ->groupBy($method);

            if ($method == 'day') {
                $stats = $stats->havingRaw('year(created_at) = '.date('y'));
            }

            $stats = $stats->get();

            foreach ($stats as $value) {
                $v = $this->$method[$value->$method - 1];
                $data[$value->$method - 1]['x'.($index + 1)] = $value->{'number_'.$index};
                $data[$value->$method - 1][$method] = $v;
            }
        }

        return $data;
    }

    /**
     * Build Donut chart
     */
    public function buildDonutChart(string $model, string $column): array
    {
        $stats = (new $model)
            ->select(DB::raw($column.' as label, count(id) as value'))
            ->groupBy('label')
            ->havingRaw($column.' is not null')
            ->get();

        return $stats->toArray();
    }
}
