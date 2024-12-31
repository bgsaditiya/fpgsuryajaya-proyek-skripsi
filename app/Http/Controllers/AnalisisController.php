<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Konfigurasi;
use App\Models\Rule;
use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

//ini controller asli
class AnalisisController extends Controller
{
    public $data; //ok
    public $total_data; //ok
    public $max_rule; //ok
    public $min_support; //ok
    public $min_count; //ok
    public $support; //ok
    public $frequent_itemset; //ok
    public $fp_list; //ok
    public static $fp_tree; //ok
    public $item; //ok
    public $conditional_pb; //ok
    public $conditional_fpt; //ok
    public $fpg; //ok
    public $association; //ok

    public $onlyItem; //ok

    public function index()
    {
        $tanggal_awal = Data::min('tanggal');
        $tanggal_akhir = Data::max('tanggal');
        // $min_support = 25;
        // $min_confidence = 75;

        return view('menu.analisis.index', [
            'title' => 'Analisis Asosiasi',
            'active' => 'analisis',
        ], compact('tanggal_awal', 'tanggal_akhir'));
    }

    public function fpgrowth(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');

        $waktu_mulai = microtime(true);

        $batas_awal = Data::min('tanggal');
        $batas_akhir = Data::max('tanggal');
        $this->validate($request, [
            'tanggal_awal'     => 'required|date|date_format:Y-m-d|after_or_equal:' . $batas_awal,
            'tanggal_akhir'     => 'required|date|date_format:Y-m-d|after_or_equal:tanggal_awal|before_or_equal:' . $batas_akhir,
            'tampilan'=> 'required|in:sederhana,lengkap'
        ],[
            'tanggal_awal.after_or_equal' => 'Tanggal awal transaksi tidak ditemukan!',
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir transaksi tidak ditemukan!',
            'tanggal_akhir.before_or_equal' => 'Tanggal akhir transaksi tidak ditemukan!',
            'max_rule.min' => 'Masukkan nilai dalam rentang 5-50!',
            'max_rule.max' => 'Masukkan nilai dalam rentang 5-50!',
            'max_rule.integer' => 'Masukkan nilai dalam rentang 5-50!',
            'tampilan.in' => 'Salah memasukkan jenis tampilan!',
        ]);

        $max_rule = $request->max_rule;

        $start_date = $request->tanggal_awal;
        $end_date = $request->tanggal_akhir;

        $tampilan = $request->tampilan;

        // dd($request->tampilan);

        try{

        //memanggil fungsi dataset
        [$onlyItem, $data, $tanggal, $total_data] = $this->dataset($start_date, $end_date, $max_rule);
        // dd($data);

        //memanggil fungsi frequent itemset
        [$frequent_itemset, $support] = $this->frequent_itemset();
        // dd($support);

        //memanggil fungsi ordered itemset
        $fp_list = $this->fp_list($onlyItem);
        //dd($fp_list);

        //memanggil fungsi fp-tree
        $this->fp_tree();

        //memanggil fungsi item
        $it = $this->item();
        //dd($this->item);

        $conditional_pb = $this->conditional_pb();

        $conditional_fpt = $this->conditional_fpt();

        $fpg = $this->fpg();

        $association = $this->association();

        array_multisort(array_column($association, 'sup'), SORT_DESC, SORT_NUMERIC, array_column($association, 'conf'), SORT_DESC, SORT_NUMERIC, array_column($association, 'lr'), SORT_DESC, SORT_NUMERIC, $association);

        $association = array_slice($association, 0, $max_rule);
        // dd($association);

        if(sizeof($data) > 10){
            $data_head = array_slice($data, 0, 5, $preserve_keys = true);
            $data_tail = array_slice($data, -5, 5, $preserve_keys = true);

        } else {
            $data_head = [];
            $data_tail = [];
        }

        if(sizeof($this->fp_list) > 10){
            $fp_list_head = array_slice($this->fp_list, 0, 5, $preserve_keys = true);
            $fp_list_tail = array_slice($this->fp_list, -5, 5, $preserve_keys = true);

        } else {
            $fp_list_head = [];
            $fp_list_tail = [];
        }

        //fungsi untuk menyimpan data rule, konfigurasi, dan arsip
        $this->insert($association, $max_rule, $start_date, $end_date);

        } catch (Throwable $e) {
            // return to_route('analisis')->withErrors('Aturan tidak ditemukan, coba konfigurasi lain!');
            return redirect()->back()->withErrors('Aturan tidak ditemukan, coba konfigurasi lain!');
        }

        $waktu_selesai = microtime(true);

        $waktu_eksekusi = $waktu_selesai - $waktu_mulai;

        return view('menu.analisis.fpg', [
            'title' => 'Frequent Pattern Growth',
            'active' => 'analisis',
        ], compact(
            'data',
            'data_head',
            'data_tail',
            'start_date',
            'end_date',
            'total_data',
            'max_rule',
            'tanggal',
            'frequent_itemset',
            'support',
            'fp_list',
            'fp_list_head',
            'fp_list_tail',
            'it',
            'conditional_pb',
            'conditional_fpt',
            'fpg',
            'association',
            'waktu_eksekusi',
            'tampilan',
        ));
    }

    public function insert($association, $max_rule, $start_date, $end_date)
    {
        $i = 0;
        foreach ($association as $key => $val) {
            $item_ante[$i] = $val['left'];
            $item_cons[$i] = $val['right'];
            $nilai_supp[$i] = $val['sup'];
            $nilai_conf[$i] = $val['conf'];
            $nilai_lift[$i] = $val['lr'];
            $i++;
        }

        $getRule = Rule::create([
            'item_ante' => $item_ante,
            'item_cons' => $item_cons,
            'nilai_supp' => $nilai_supp,
            'nilai_conf' => $nilai_conf,
            'nilai_lift' => $nilai_lift,
        ]);

        $getKonf = Konfigurasi::create([
            'jum_data' => $this->total_data,
            'max_rule' => $max_rule,
            'tgl_awal' => $start_date,
            'tgl_akhir' => $end_date,
        ]);

        Arsip::create([
            'id_rule' => $getRule->id_rule,
            'username' => auth()->user()->username,
            'id_konf' => $getKonf->id_konf,
            'tgl_analisis' => date('Y-m-d H:m:s'),
        ]);
    }

    public function dataset($start_date, $end_date, $max_rule)
    {
        //mengambil dataset dari database yang sesuai rentang tanggal
        $this->data = Data::select('id_transaksi', 'item', 'tanggal')
            ->whereBetween('tanggal', [$start_date, $end_date])
            ->get();
        // dd($this->frequent_itemset);
        //memperoleh tanggal transaksi berdasarkan id transaksi
        foreach ($this->data as $row) {
            $tanggal[$row->id_transaksi] = $row->tanggal;
        }
        $onlyItem = $this->data->groupBy('id_transaksi')->makeHidden(['id_transaksi', 'tanggal'])->toArray();
        // dd($onlyItem);

        //menggabungkan item dengan id transaksi yang sama
        $data = $this->data->groupBy('id_transaksi')->toArray();

        //menghitung jumlah data transaksi
        $this->total_data = count($data);

        $this->frequent_itemset = $this->data->countBy('item')->sortDesc();

        // dd($this->frequent_itemset);

        if(sizeof($this->frequent_itemset) > $max_rule){
            $this->min_count = $this->frequent_itemset->take($max_rule)->last();
        }else{
            $this->min_count = $this->frequent_itemset->last();
        }

        return [$onlyItem, $data, $tanggal, $this->total_data];
    }

    public function frequent_itemset()
    {
        //proses seleksi item yang memenuhi nilai minimum support
        foreach ($this->frequent_itemset as $key => $val) {
            if ($val < $this->min_count) {
                unset($this->frequent_itemset[$key]);
            } else {
                $this->support[$key] = $val / $this->total_data * 100;
            }
        }
        //mengurutkan item berdasarkan frekuensi terbesar
        $this->frequent_itemset = $this->frequent_itemset->sortDesc();

        // dd($this->frequent_itemset);

        return [$this->frequent_itemset, $this->support];
    }

    public function fp_list($onlyItem)
    {
        // dd($onlyItem);
        foreach ($onlyItem as $data => $val) {
            $ar = array();
            foreach ($val as $key => $f) {
                foreach ($f as $g => $k) {
                    $ar[$k] = $k;
                }
            }
            if ($ar) {
                $this->onlyItem[$data] = $ar;
            }
        }
        // dd($this->onlyItem);

        foreach ($this->onlyItem as $data) {
            $arr = array();
            foreach ($this->frequent_itemset as $category => $count) {
                // dd($data);
                if (in_array($category, $data))
                    $arr[] = $category;
            }
            if ($arr) {
                $this->fp_list[] = $arr;
            }
        }
        // dd($this->fp_list);

        return $this->fp_list;
    }

    public function fp_tree()
    {
        static::$fp_tree = array(
            'Root' => array(
                'value' => 'Root',
                'count' => 0,
                'next' => array(),
            ),
        );

        $this->build_tree(static::$fp_tree['Root']['next'], $this->fp_list);
    }

    public function build_tree(&$parent_node, $fp_list = array())
    {
        // digunakan untuk mengindeks ulang kunci array fp-list
        $fp_list = array_values($fp_list);

        if (!$fp_list)
            return;

        $fp_list[0] = array_values($fp_list[0]);

        // mendapatkan item dan itemset pada fp-list
        $itemset = current($fp_list);
        $item = current($itemset);

        // menghapus elemen pertama array fp-list
        unset($fp_list[0][0]);

        if (!$itemset) {
            unset($fp_list[0]);
            $this->build_tree(static::$fp_tree['Root']['next'], $fp_list);
        } else if (in_array($item, array_keys($parent_node))) {
            $parent_node[$item]['count']++;
            $this->build_tree($parent_node[$item]['next'], $fp_list);
        } else {
            $parent_node[$item]['value'] = $item;
            $parent_node[$item]['count'] = 1;
            $parent_node[$item]['next'] = array();
            $this->build_tree($parent_node[$item]['next'], $fp_list);
        }
    }

    public static function display()
    {
        echo "<ul class='fp_tree'><li><b class='btn btn-sm btn-danger'>Root</b>";
        static::cabang(static::$fp_tree['Root']);
        echo "</li></ul>";
    }

    public static function cabang($tree)
    {
        echo "<ul>";
        foreach ($tree['next'] as $key => $val) {
            echo "<li> <b class='btn btn-sm' id='item'>$key: $val[count]</b>";
            static::cabang($val);
            echo '</li>';
        }
        echo "</ul>";
    }

    public function item()
    {
        $frequent = $this->frequent_itemset->toArray();
        $this->item = array_reverse($frequent, true);
        // dd($this->item);

        return $this->item;
    }

    public function conditional_pb()
    {
        $this->_conditional_pb(array(), static::$fp_tree['Root']);
        $arr = array();
        // dd($this->conditional_pb);
        foreach ($this->conditional_pb as $key => $val) {
            // dd(count($val['items']));
            if (count($val['items']) > 1) {
                // $key = $val['items'][count($val['items']) - 1];
                $key = end($val['items']);
                // dd($val['items'][count($val['items']) - 1]);
                array_pop($val['items']);
                $arr[$key][] = $val;
                // dd($arr);
            }
        }
        $this->conditional_pb = $arr;

        // dd($this->conditional_pb);

        return $this->conditional_pb;
    }

    public function _conditional_pb($items, $tree)
    {
        // dd($tree);
        if ($tree['value'] != 'Root') {
            // dd($tree['value']);
            $items[] = $tree['value'];
            $this->conditional_pb[] = array(
                'value' => $tree['value'],
                'items' => $items,
                'count' => $tree['count'],
            );
        }

        foreach ($tree['next'] as $key => $val) {
            // dd($val);
            $this->_conditional_pb($items, $val);
        }
        // dd($this->conditional_pb);
    }

    public function conditional_fpt()
    {
        foreach ($this->item as $key => $val) {
            // dd(isset($this->conditional_pb[$key]));
            //jika terdapat cpb[key]
            if (isset($this->conditional_pb[$key])) {
                //maka memanggil fungsi _conditional_fpt
                $this->conditional_fpt[$key] = $this->_conditional_fpt($this->conditional_pb[$key]);
            }
        }

        // dd($this->conditional_fpt);
        return $this->conditional_fpt;
    }

    public function _conditional_fpt($data)
    {
        $key = array();
        $max = 0;

        // dd($data);
        foreach ($data as $val) {

            //mengambil panjang maksimal disetiap transaksi
            if (count($val['items']) > $max)
                $max = count($val['items']);

            foreach ($val['items'] as $k => $v) {
                $key[$v] = 1;
            }
        }
        $key = array_keys($key);
        // dd($max);
        $itemset = $max;
        $arr3 = array();
        while ($itemset >= 1) {
            $com = array();
            $com = getCombinations($key, $itemset);
            // dd($com);

            foreach ($com as $k => $v) {
                // dd($v);
                $result = $this->get_result($v, $data);
                if ($result['count'] > 0)
                    $arr3[] = $result;
            }
            $itemset--;
        }
        return $arr3;
    }

    public function get_result($com, $data)
    {
        $total = 0;
        foreach ($data as $key => $val) {
            if ($this->match($com, $val['items']))
                $total += $val['count'];
        }
        return array(
            'items' => $com,
            'count' => $total,
        );
    }

    public function match($needed, $data)
    {
        foreach ($needed as $key => $val) {
            if (!in_array($val, $data))
                return false;
        }
        return true;
    }

    public function fpg()
    {
        $arr = array();
        foreach ($this->conditional_fpt as $key => $val) {
            foreach ($val as $k => $v) {
                $items = $v['items'];
                // dd($items);
                $items[] = $key;
                // dd($items);
                // $count = count($items);
                $arr[$key][] = array(
                    'items' => $items,
                    'count' => $v['count'],
                );
            }
        }
        $this->fpg = $arr;
        // dd($this->fpg);

        return $this->fpg;
    }

    function association()
    {
        $no = 0;
        $arr2 = array();
        foreach ($this->fpg as $k => $v) {
            foreach ($v as $item_key => $item_val) {
                $items = $item_val['items'];
                $arr = array();
                for ($a = 0; $a < count($items) - 1; $a++) {
                    // dd($a);
                    $arr = array_merge(getCombinations($items, $a + 1), $arr);

                }
                // dd($arr);
                // dd($items);
                foreach ($arr as $key => $val) {
                    $keys = array(
                        'left' => array(),
                        'right' => array(),
                    );
                    foreach ($items as $k => $v) {
                        if (in_array($v, $val))
                            $keys['left'][] = $v;
                        else
                            $keys['right'][] = $v;

                    }
                    // dd($keys);
                    $arr2[$no] = $keys;
                    // dd($this->get_match($arr2[$no]['right']));
                    $arr2[$no]['b'] = $this->get_match($arr2[$no]['left']);
                    // dd($arr2[$no]['b']);
                    $arr2[$no]['a'] = $item_val['count'];
                    $arr2[$no]['total'] = $this->total_data;
                    $arr2[$no]['sup'] = $arr2[$no]['a'] / $arr2[$no]['total'];
                    // dd($arr2[$no]['a']);
                    $arr2[$no]['conf'] = $arr2[$no]['a'] / $arr2[$no]['b'];
                    $s_head = $this->get_match($arr2[$no]['right']) / $this->total_data;
                    // dd($this->get_match($arr2[$no]['right']));
                    $arr2[$no]['lr'] = $arr2[$no]['conf'] / $s_head;
                    // $arr2[$no]['lr'] = $arr2[$no]['sup'] / ( ( $this->get_match($arr2[$no]['left']) / $this->total_data) * ($this->get_match($arr2[$no]['right']) / $this->total_data ));
                    $no++;
                }

            }
        }
        // dd($keys);

        // dd($arr2);

        foreach ($arr2 as $a2 => $a) {
            $arr2[$a2]['merge'] = array_merge($arr2[$a2]['left'], $arr2[$a2]['right']);
        }

        $this->association = $arr2;

        return $this->association;
    }

    public function get_match($needed)
    {
        $matches = 0;
        // dd($this->onlyItem);
        foreach ($this->onlyItem as $k => $v) {
            // dd($v);
            $arr = array();
            foreach ($v as $a => $b) {
                if (in_array($b, $needed)) {
                    $arr[] = $b;
                }
            }
            // dd($arr);

            if (count($arr) == count($needed)) {
                $matches++;
            }
        }
        return $matches;
    }
}

function getCombinations($base, $n)
{
    $baselen = count($base);
    if ($baselen == 0) {
        return;
    }
    if ($n == 1) {
        $return = array();
        foreach ($base as $b) {
            $return[] = array($b);
        }
        return $return;
    } else {
        $oneLevelLower = getCombinations($base, $n - 1);
        // dd($oneLevelLower);
        $newCombs = array();
        foreach ((array) $oneLevelLower as $oll) {
            $lastEl = $oll[$n - 2];
            $found = false;
            foreach ($base as  $key => $b) {
                if ($b == $lastEl) {
                    $found = true;
                    continue;
                }
                if ($found == true) {
                    if ($key < $baselen) {
                        $tmp = $oll;
                        $newCombination = array_slice($tmp, 0);
                        $newCombination[] = $b;
                        $newCombs[] = array_slice($newCombination, 0);
                    }
                }
            }
        }
    }
    return $newCombs;
}
