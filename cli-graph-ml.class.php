<?php
ini_set( 'default_charset', 'UTF-8' );

/** cli-graph-ml.class.php
 *  
 * Class for visualize data in bar graph & detect outliers
 * 
 *     Months in %
 *      _____________
 *   38|___________▌_
 *   35|___________▌_
 * A 32|___________▌_
 * X 29|___________▌_
 * I 26|___________▌_
 * S 23|__________▌▌_
 *   20|_________▌▌▌_
 * Y 17|_______▌▌▌▌▌_
 *   14|______▌▌▌▌▌▌_
 *   11|___▌▌▌▌▌▌▌▌▌_
 *     +-------------
 *       |    |    |
 *      Jan  Jun  Dec
 *         AXIS X
 *      Max: 38
 *      Min: 1
 *      Sum: 132
 *      Avg: 12.00
 *      Median: 9.00
 *      Variance: 12.00
 *      Std Desv: 3.46
 *      O. Up Lim: 22.39
 *      O. Do Lim: 1.61
 *
 * 
 * 
 * @author Rafael Martin Soto
 * @author {@link https://www.inatica.com/ Inatica}
 * @blog {@link https://rafamartin10.blogspot.com/ Blog Rafael Martin Soto}
 * @since September 2021
 * @version 1.0.2
 * @license GNU General Public License v3.0
 * 
 * @param string $data
 * @param array $axis_x_values
 * @param string $config
 *
 * Some utils docs:
 * https://en.wikipedia.org/wiki/List_of_Unicode_characters
 * https://www.w3schools.com/charsets/ref_utf_box.asp
 * https://compwright.com/2012-11-26/box-drawing-in-php/
 * 
 * U+2580	▀	Upper half block
 * U+2581	▁	Lower one eighth block
 * U+2582	▂	Lower one quarter block
 * U+2583	▃	Lower three eighths block
 * U+2584	▄	Lower half block
 * U+2585	▅	Lower five eighths block
 * U+2586	▆	Lower three quarters block
 * U+2587	▇	Lower seven eighths block
 * U+2588	█	Full block
 * U+2589	▉	Left seven eighths block
 * U+258A	▊	Left three quarters block
 * U+258B	▋	Left five eighths block
 * U+258C	▌	Left half block
 * U+258D	▍	Left three eighths block
 * U+258E	▎	Left one quarter block
 * U+258F	▏	Left one eighth block
 * U+2590	▐	Right half block
 * 
 * U+2591	░	Light shade
 * 
 * U+2592	▒	Medium shade
 * 
 * U+2593	▓	Dark shade
 * 
 * U+2594	▔	Upper one eighth block
 * U+2595	▕	Right one eighth block
 * U+2596	▖	Quadrant lower left
 * U+2597	▗	Quadrant lower right
 * U+2598	▘	Quadrant upper left
 * U+2599	▙	Quadrant upper left and lower left and lower right
 * U+259A	▚	Quadrant upper left and lower right
 * U+259B	▛	Quadrant upper left and upper right and lower left
 * U+259C	▜	Quadrant upper left and upper right and lower right
 * U+259D	▝	Quadrant upper right
 * U+259E	▞	Quadrant upper right and lower left
 * U+259F	▟	Quadrant upper right and lower left and lower right
 * */

 class cli_graph_ml
    {
    private $Upper_half_block;
    private $Lower_one_eighth_block;
    private $Lower_one_quarter_block;
    private $Lower_three_eighths_block;
    private $Lower_half_block;
    private $Lower_five_eighths_block; 
    private $Lower_three_quarters_block;
    private $Lower_seven_eighths_block; 
    private $Full_block; 
    private $Left_seven_eighths_block; 
    private $Left_three_quarters_block; 
    private $Left_five_eighths_block; 
    private $Left_half_block; 
    private $Left_three_eighths_block; 
    private $Left_one_quarter_block; 
    private $Left_one_eighth_block; 
    private $Right_half_block; 
    private $Light_shade; 
    private $Medium_shade; 
    private $Upper_one_eighth_block;
    private $Right_one_eighth_block;
    private $Quadrant_lower_left; 
    private $Quadrant_lower_right; 
    private $Quadrant_upper_left;
    private $Quadrant_upper_left_and_lower_left_and_lower_right;
    private $Quadrant_upper_left_and_lower_right;
    private $Quadrant_upper_left_and_upper_right_and_lower_left;
    private $Quadrant_upper_left_and_upper_right_and_lower_right;
    private $Quadrant_upper_right; 
    private $Quadrant_upper_right_and_lower_left; 
    private $Quadrant_upper_right_and_lower_left_and_lower_right ;

    /**
     * Border Characters
     * see: https://unicode-table.com/en/blocks/box-drawing/
     *
     * @var    array
     * @access private
     *
     **/
    private $border_chars = [
        'simple' => [
            'top'          => '-',
            'top-mid'      => '+',
            'top-left'     => '+',
            'top-right'    => '+',
            'bottom'       => '-',
            'bottom-mid'   => '+',
            'bottom-left'  => '+',
            'bottom-right' => '+',
            'left'         => '|',
            'left-mid'     => '+',
            'mid'          => '-',
            'mid-mid'      => '+',
            'right'        => '|',
            'right-mid'    => '+',
            'middle'       => '|'
            ],
        'single' => [
            'right-mid'    => '+',
            'top'          => '─',
            'top-mid'      => '┬',
            'top-left'     => '┌',
            'top-right'    => '┐',
            'bottom'       => '─',
            'bottom-mid'   => '┴',
            'bottom-left'  => '└',
            'bottom-right' => '┘',
            'left'         => '│',
            'left-mid'     => '├',
            'mid'          => '─',
            'mid-mid'      => '┼',
            'right'        => '│',
            'right-mid'    => '┤',
            'middle'       => '│'
            ],
        'double' => [
            'top'          => '═',
            'top-mid'      => '╦',
            'top-left'     => '╔',
            'top-right'    => '╗',
            'bottom'       => '═',
            'bottom-mid'   => '╩',
            'bottom-left'  => '╚',
            'bottom-right' => '╝',
            'left'         => '║',
            'left-mid'     => '╠',
            'mid'          => '═',
            'mid-mid'      => '╬',
            'right'        => '║',
            'right-mid'    => '╣',
            'middle'       => '║'
            ],
        'double_single' => [
            'top'          => '═',
            'top-mid'      => '╤',
            'top-left'     => '╔',
            'top-right'    => '╗',
            'bottom'       => '═',
            'bottom-mid'   => '╧',
            'bottom-left'  => '╚',
            'bottom-right' => '╝',
            'left'         => '║',
            'left-mid'     => '╟',
            'mid'          => '─',
            'mid-mid'      => '┼',
            'right'        => '║',
            'right-mid'    => '╢',
            'middle'       => '│'
            ]
    ]; // Border Chars



    /**
     * colors
     * chr(27).'[1;34m',
     *
     * @var    array
     * @access private
     *
     **/
    private $text_colors = [
        'lightblue'     => '[1;34m',
        'lightred'      => '[1;31m',
        'lightgreen'    => '[1;32m',
        'lightyellow'   => '[1;33m',
        'lightblack'    => '[1;30m',
        'lightmagenta'  => '[1;35m',
        'lightcyan'     => '[1;36m',
        'lightwhite'    => '[1;37m',
        'blue'          => '[0;34m',
        'red'           => '[0;31m',
        'green'         => '[0;32m',
        'yellow'        => '[0;33m',
        'black'         => '[0;30m',
        'magenta'       => '[0;35m',
        'cyan'          => '[0;36m',
        'white'         => '[0;37m',
        'orange'        => '[38;5;214m', // if supported by the terminal
        'reset'         => '[0m',
    ]; // /$text_colors



    /**
     * Definition of Defaut Table Format values
     *
     * @var    array
     * @access private
     *
     **/
    private $default_cfg = [
        'block_type'    => 'Full_block', // not used for now
        'orientation'   => 'V', // for now only 'V'
        'graph_type'    => 'bar', // For now only 'bar'
        'border_chars'  => 'simple', // for now only 'simple'
        'graph_length'  => 10,
        'bar_color'  => 'lightwhite',
        'title'  => '',
        'draw_underlines'  => true,
        'underlines_every'  => 1,
        'bar_width'  => 1,
        'show_y_axis_title'  => true,
        'show_x_axis_title'  => true,
        'x_axis_title' => 'AXIS X',
        'y_axis_title' => 'AXIS Y',
        'padding_left'  => 1,
        'padding_right'  => 1,
        'padding_top'  => 1,
        'padding_bottom'  => 1,
        'explain_values'  => true,
        'explain_values_same_line'  => false        
    ]; // /$default_cfg


    private $data = [];
    private $count_data;
    private $arr_output = [];
    private $axis_x_values;
    
    private $graph_length;
    private $max_value;
    private $min_value;
    private $arr_prepare_output = [];

    private $outlier_factor = 2;
    private $outl_up_limit = 0;
    private $outl_down_limit = 0;
    private $arr_id_data_visible = []; // Array with the id's even the value is 0 and cannot be drawed in graph, but we need to know if there is a min() value in data. Then draw it with Lower_one_eighth_block
   
	
    public function __construct( $data = null, $axis_x_values = null, $config = null) {
		if( !is_null($config) ){
        	$this->set_config( $config );
        }

		if( !is_null($data) ){
        	$this->set_data( $data );
        }

		if( !is_null($axis_x_values) ){
        	$this->set_axis_x_values( $axis_x_values );
        }

        $this->Upper_half_block                                     = html_entity_decode('▀', ENT_NOQUOTES, 'UTF-8'); 
        $this->Lower_one_eighth_block                               = html_entity_decode('▁', ENT_NOQUOTES, 'UTF-8'); 
        $this->Lower_one_quarter_block                              = html_entity_decode('▂', ENT_NOQUOTES, 'UTF-8'); 
        $this->Lower_three_eighths_block                            = html_entity_decode('▃', ENT_NOQUOTES, 'UTF-8'); 
        $this->Lower_half_block                                     = html_entity_decode('▄', ENT_NOQUOTES, 'UTF-8'); 
        $this->Lower_five_eighths_block                             = html_entity_decode('▅', ENT_NOQUOTES, 'UTF-8'); 
        $this->Lower_three_quarters_block                           = html_entity_decode('▆', ENT_NOQUOTES, 'UTF-8'); 
        $this->Lower_seven_eighths_block                            = html_entity_decode('▇', ENT_NOQUOTES, 'UTF-8'); 
        $this->Full_block                                           = html_entity_decode('█', ENT_NOQUOTES, 'UTF-8'); 
        $this->Left_seven_eighths_block                             = html_entity_decode('▉', ENT_NOQUOTES, 'UTF-8'); 
        $this->Left_three_quarters_block                            = html_entity_decode('▊', ENT_NOQUOTES, 'UTF-8'); 
        $this->Left_five_eighths_block                              = html_entity_decode('▋', ENT_NOQUOTES, 'UTF-8'); 
        $this->Left_half_block                                      = html_entity_decode('▌', ENT_NOQUOTES, 'UTF-8'); 
        $this->Left_three_eighths_block                             = html_entity_decode('▍', ENT_NOQUOTES, 'UTF-8'); 
        $this->Left_one_quarter_block                               = html_entity_decode('▎', ENT_NOQUOTES, 'UTF-8'); 
        $this->Left_one_eighth_block                                = html_entity_decode('▏', ENT_NOQUOTES, 'UTF-8'); 
        $this->Right_half_block                                     = html_entity_decode('▐', ENT_NOQUOTES, 'UTF-8'); 
        $this->Light_shade                                          = html_entity_decode('░', ENT_NOQUOTES, 'UTF-8'); 
        $this->Medium_shade                                         = html_entity_decode('▒', ENT_NOQUOTES, 'UTF-8'); 
        $this->Upper_one_eighth_block                               = html_entity_decode('▔', ENT_NOQUOTES, 'UTF-8'); 
        $this->Right_one_eighth_block                               = html_entity_decode('▕', ENT_NOQUOTES, 'UTF-8'); 
        $this->Quadrant_lower_left                                  = html_entity_decode('▖', ENT_NOQUOTES, 'UTF-8'); 
        $this->Quadrant_lower_right                                 = html_entity_decode('▗', ENT_NOQUOTES, 'UTF-8'); 
        $this->Quadrant_upper_left                                  = html_entity_decode('▘', ENT_NOQUOTES, 'UTF-8'); 
        $this->Quadrant_upper_left_and_lower_left_and_lower_right   = html_entity_decode('▙', ENT_NOQUOTES, 'UTF-8'); 
        $this->Quadrant_upper_left_and_lower_right                  = html_entity_decode('▚', ENT_NOQUOTES, 'UTF-8'); 
        $this->Quadrant_upper_left_and_upper_right_and_lower_left   = html_entity_decode('▛', ENT_NOQUOTES, 'UTF-8'); 
        $this->Quadrant_upper_left_and_upper_right_and_lower_right  = html_entity_decode('▜', ENT_NOQUOTES, 'UTF-8'); 
        $this->Quadrant_upper_right                                 = html_entity_decode('▝', ENT_NOQUOTES, 'UTF-8'); 
        $this->Quadrant_upper_right_and_lower_left                  = html_entity_decode('▞', ENT_NOQUOTES, 'UTF-8'); 
        $this->Quadrant_upper_right_and_lower_left_and_lower_right  = html_entity_decode('▟', ENT_NOQUOTES, 'UTF-8');

        $this->graph_length = $this->get_cfg_param('graph_length');
        $this->bar_width = $this->get_cfg_param('bar_width');
	} // / __construct



    /**
     * Set DATA
     * @param array $data
     */
    public function set_data( $data ){
        $this->data = $data;
        $this->count_data = count( $this->data );
        $this->max_value = max( $this->data );
        $this->min_value = min( $this->data );
    }// /set_data()


    
    /**
     * Set array of id's visibles even the value is 0
     * Array with the id's even the value is 0 and cannot be drawed in graph, but we need to know if there is a min() value in data. Then draw it with Lower_one_eighth_block
     * @param array $arr_id_data_visible
     */
    public function set_arr_id_data_visible( $arr_id_data_visible ){
        $this->arr_id_data_visible = $arr_id_data_visible;
    }// /set_arr_id_data_visible()


    /**
     * Set EXPLAIN VALUES
     * @param boolean $explain_values
     */
    public function set_explain_values( $explain_values = true ){
        $this->config['explain_values'] = $explain_values;
    }// /set_explain_values()



    /**
     * Set BAR COLOR
     * @param string $bar_color
     */
    public function set_bar_color( $bar_color = 'lightwhite' ){
        $this->config['bar_color'] = $bar_color;
    }// /set_bar_color()

    

    /**
     * Set EXPLAIN VALUES SAME LINE
     * @param boolean $explain_values_same_line
     */
    public function set_explain_values_same_line( $explain_values_same_line = true ){
        $this->config['explain_values_same_line'] = $explain_values_same_line;
        if( $this->config['explain_values_same_line'] ){
            $this->set_explain_values(  ); // Default true
        }
    }// /set_explain_values_same_line()



    /**
     * Set Outlier Factor
     * @param double $outlier_factor
     */
    public function set_outlier_factor( $outlier_factor = 2 ){
        $this->outlier_factor = $outlier_factor;
    }// /set_outlier_factor()



    /**
     * Set TITLE
     * @param string $title
     */
    public function set_title( $title = '' ){
        $this->config['title'] = $title;
    }// /set_title()


    /**
     * Set draw underlines every x rows
     * @param integer $underlines_every
     */
    public function set_underlines_every( $underlines_every = 1 ){
        $this->config['underlines_every'] = $underlines_every;
    }// /set_underlines_every()



    /**
     * Set X AXIS TITLE
     * @param string $x_axis_title
     */
    public function set_x_axis_title( $x_axis_title = '' ){
        $this->config['x_axis_title'] = $x_axis_title;
    }// /set_x_axis_title()



    /**
     * Set Y AXIS TITLE
     * @param string $y_axis_title
     */
    public function set_y_axis_title( $y_axis_title = '' ){
        $this->config['y_axis_title'] = $y_axis_title;
    }// /set_y_axis_title()



    /**
     * Set SHOW X AXIS TITLE
     * @param boolean $show_x_axis_title
     */
    public function set_show_x_axis_title( $show_x_axis_title = true ){
        $this->config['show_x_axis_title'] = $show_x_axis_title;
    }// /set_show_x_axis_title()



    /**
     * Set SHOW Y AXIS TITLE
     * @param boolean $show_y_axis_title
     */
    public function set_show_y_axis_title( $show_y_axis_title = true ){
        $this->config['show_y_axis_title'] = $show_y_axis_title;
    }// /set_show_y_axis_title()



    /**
     * Set SHOW X,Y AXIS TITLE
     * @param boolean $show_axis_titles
     */
    public function set_show_axis_titles( $show_axis_titles = true ){
        $this->set_show_x_axis_title( $show_axis_titles );
        $this->set_show_y_axis_title( $show_axis_titles );
    }// /set_show_axis_titles()



    /**
     * Set PADDING
     * @param integer $padding
     */
    public function set_padding( $padding = 1 ){
        $this->set_left_padding( $padding );
        $this->set_right_padding( $padding );
        $this->set_top_padding( $padding );
        $this->set_bottom_padding( $padding );
    }// /set_padding()



    /**
     * Set SET LEFT PADDING
     * @param integer $left_padding
     */
    public function set_left_padding( $left_padding = 1 ){
        $this->config['left_padding'] = $left_padding;
    }// /set_left_padding()



    /**
     * Set SET RIGHT PADDING
     * @param integer $left_padding
     */
    public function set_right_padding( $right_padding = 1 ){
        $this->config['right_padding'] = $right_padding;
    }// /set_right_padding()



    /**
     * Set SET TOP PADDING
     * @param integer $top_padding
     */
    public function set_top_padding( $top_padding = 1 ){
        $this->config['top_padding'] = $top_padding;
    }// /set_top_padding()



    /**
     * Set SET BOTTOM PADDING
     * @param integer $bottom_padding
     */
    public function set_bottom_padding( $bottom_padding = 1 ){
        $this->config['bottom_padding'] = $bottom_padding;
    }// /set_bottom_padding()



    /**
     * Set Graph Length
     * @param integer $length
     */
    public function set_graph_length( $length = 10 ){
        $this->graph_length = $length;
    }// /set_graph_length()



    /**
     * Set DRAW UNDERLINES
     * @param boolean $draw_underlines
     */
    public function set_draw_underlines( $draw_underlines = true ){
        $this->config['draw_underlines'] = $draw_underlines;
    }// /set_draw_underlines()

    

    /**
     * Set BAR WIDTH
     * @param integer $bar_width
     */
    public function set_bar_width( $bar_width = 1 ){
        $this->bar_width = $bar_width;
    } // /set_bar_width()

    

    /**
     * Set AXIS X VALUES
     * @param array $axis_x_values
     */
    public function set_axis_x_values( $axis_x_values ){
        $this->axis_x_values = $axis_x_values;
    } // /set_axis_x_values()



    /**
     * Set CONFIG
     * @param array $config
     */
    public function set_config( $config ){
        $this->config = $config;
    } // /set_config()



    /**
     * Get Config PARAM
     * @param string $param
     * @return string $param
     */
    private function get_cfg_param( $param ){
        return ((isset($this->config[$param]))?$this->config[$param]:$this->default_cfg[$param]);
    }// /get_cfg_param()



    /**
     * Get Str chars of down X axis border
     * 
     * @return string $border
     */
    private function get_down_border( ){
        $border_cfg = $this->border_chars[$this->get_cfg_param( 'border_chars' )];

        $chr_corner = html_entity_decode( $border_cfg['bottom-left'], ENT_NOQUOTES, 'UTF-8');
        $chr_line   = html_entity_decode( $border_cfg['bottom'], ENT_NOQUOTES, 'UTF-8');

        unset( $border_cfg );

        return $chr_corner.str_pad( '', $this->count_data*$this->bar_width+2, $chr_line); // +2 free space left & right
    } // /get_down_border()



    /**
     * Get Str chars of up X axis border
     * 
     * @return string $border
     */
    private function get_up_border( ){
        $chr_corner = ' ';
        $chr_line   = '_';

        return $chr_corner.str_pad( '', $this->count_data*$this->bar_width+2, $chr_line); // +2 = free space left and right
    } // /get_up_border()



    /**
     * Get Str Axis X values
     * 
     * @return string $str_axis_x_values
     */
    private function get_axis_x_values( ){
        return $this->justify(implode(' ', $this->axis_x_values), $this->count_data*$this->bar_width + 2 ); // The left and right margin of the graph will be used
    } // /get_axis_x_values()



    /**
     * Get Str Axis X separators
     * Used after draw down line of chart
     * 
     * @return string $str_axis_x_separators
     */
    private function get_axis_x_separators( ){
        $arr_separators = array_fill(0, count($this->axis_x_values), '|');
        return $this->justify(implode(' ', $arr_separators), $this->count_data*$this->bar_width);
    } // /get_axis_x_separators()



    /**
     * Prepare Graph Lines
     */
    private function prepare_graph_lines( ){
        $this->arr_prepare_output = [];

        for( $i=0; $i<$this->count_data; $i++ ){
            $full = (int) ($this->data[$i] * ($this->graph_length) / $this->max_value);
            $empty = $this->graph_length - $full;

            $StrPrepare = '';

            if($full > 0){
                $StrPrepare .= str_repeat('1', $full);
            }

            if($empty > 0){
                $StrPrepare .= str_repeat('0', $empty);
            }

            $this->arr_prepare_output[] = $StrPrepare;
        }
    } // /prepare_graph_lines()



    /**
     * Get Graph Line
     * 
     * @param integer $id_line (begin 0 with top line graph)
     * @return string str_line
     */
    private function get_graph_line( $id_line ){
        $Str_line = '';
        $chr_underlines = (( $this->get_cfg_param( 'draw_underlines') && (($id_line+1)%$this->get_cfg_param( 'underlines_every') == 0))?'_':' ');
        foreach($this->data as $key=>$data){
            if($this->arr_prepare_output[$key][$this->graph_length-$id_line-1]=='1'){
                $Str_line .= chr(27);
                $color = $this->text_colors[ $this->get_cfg_param( 'bar_color') ];
                if( $this->get_cfg_param( 'explain_values' ) && ($data < $this->outl_down_limit || $data > $this->outl_up_limit) ){
                    $color = $this->text_colors[ 'red' ];
                }
                $Str_line .= $color;
                for($i=0;$i<$this->bar_width-1;$i++){
                    $Str_line .= $this->Full_block;
                }
                //Quadrant_lower_left
                $Str_line .= $this->Left_half_block;

                $Str_line .= chr(27).'[0m';
            } else {
                if($this->graph_length-1 == $id_line && in_array($key, $this->arr_id_data_visible)){
                    // We need to draw someting to show the value exists, unless is 0
                    for($i=0;$i<$this->bar_width-1;$i++){
                        $Str_line .= $this->Lower_half_block;
                    }
                    $Str_line .= $this->Lower_half_block; //$this->Quadrant_lower_left; // dont work ????
                } else {
                    for($i=0;$i<$this->bar_width;$i++){
                        $Str_line .= $chr_underlines; // Fill with graph char code of ' '
                    }
                }
            }
        }

        return $Str_line;
    } // /get_graph_line()



    /**
     * Prepare Output in Array
     */
    public function prepare_array_output( ){
        $this->arr_output = [];

        $border_cfg = $this->border_chars[$this->get_cfg_param( 'border_chars' )];
        $chr_border_left = $border_cfg['left'];

        $y_blocks = (($this->max_value-$this->min_value) / $this->graph_length);
        $max_y_length = strlen($this->max_value);
        // if is <10, we need to add 1 decimal. Then the strlen is added with decimal separator and one number
        if($this->max_value - $this->min_value < 10){
            $max_y_length += 2;
        }

        // Padding left
        $str_padding_left = str_repeat(' ', $this->get_cfg_param( 'padding_left' ));

        // Blank space of left values
        $str_blank_left_values = str_repeat(' ', $max_y_length);

        // Bolank char for title Axis Y
        $str_char_title_y = (( $this->get_cfg_param( 'show_y_axis_title' ))?'  ':''); // One space for the title & other for separate from 'Axis Y' values

        // Padding right
        $str_padding_right= str_repeat(' ', $this->get_cfg_param( 'padding_right' ));

        // Som math calcs
        if( $this->get_cfg_param( 'explain_values' ) ){
            $Sum = array_sum($this->data);
            $avg = $Sum / $this->count_data;
            $arr_sort = $this->data;
            $pos_median = ($this->count_data + 1) / 2;
            sort($arr_sort, SORT_NUMERIC );
            $median = (double)((($this->count_data % 2 != 0)) ? $arr_sort[$pos_median - 1] : ($arr_sort[$pos_median - 1] + $arr_sort[$pos_median]) / 2);
            $sum_median = 0;

            for($i=0; $i<$this->count_data;$i++){
                $substract = $this->data[$i] - $avg;
				$sum_median += $substract * $substract; // pow($substract, 2);
            }

            $vari = $sum_median/$this->count_data;
            $std = sqrt($vari);

            $this->outl_up_limit = $avg + $std * $this->outlier_factor;
            $this->outl_down_limit = $avg - $std * $this->outlier_factor;

            $avg = number_format($avg, 2, '.', '');
        }

        // Prepare Graph Lines
        $this->prepare_graph_lines();

		$left = $str_padding_left.$str_char_title_y.$str_blank_left_values;
        
        // Padding Top
        for( $i=$this->get_cfg_param( 'padding_top' ); $i> 0; $i-- ){
            $this->arr_output[] = $left.str_pad('', $this->count_data * $this->bar_width + 1 + 2, ' ', STR_PAD_BOTH).$str_padding_right; // +1 = vertical col axis separator, +2 = free space left and right
        }
        // Graph Title
        $this->arr_output[] = $left.str_pad($this->get_cfg_param( 'title' ), $this->count_data * $this->bar_width + 1 + 2, ' ', STR_PAD_BOTH).$str_padding_right; // +1 = vertical col axis separator, +2 = free space left and right

        
        // Down border line
        if( $this->get_cfg_param( 'draw_underlines' ) ){
            $this->arr_output[] = $left.$this->get_up_border().$str_padding_right;
        }

        // Axis X Title
        if( $this->get_cfg_param( 'show_y_axis_title' ) ){
            $str_pad_axis_y_title = str_pad($this->get_cfg_param( 'y_axis_title' ), $this->graph_length, ' ', STR_PAD_BOTH);
        }

        // Get array of string graph
        for($i=0; $i<$this->graph_length;$i++){
            if($this->max_value - $this->min_value < 10){
                $value_y = number_format($this->max_value-$y_blocks*$i, 1, '.', '' );
            } else {
                $value_y = (int)($this->max_value-$y_blocks * $i);
            }
            $value_y = str_pad($value_y, $max_y_length, ' ', STR_PAD_LEFT);
            $str_char_title_y_loop = (( $this->get_cfg_param( 'show_y_axis_title' ))?$str_pad_axis_y_title[$i].' ':'');
            $chr_underlines = (( $this->get_cfg_param( 'draw_underlines') && (($i+1)%$this->get_cfg_param( 'underlines_every') == 0))?'_':' ');
            
            $this->arr_output[] = $str_padding_left.$str_char_title_y_loop.$value_y.$chr_border_left.$chr_underlines.$this->get_graph_line($i).$chr_underlines.$str_padding_right;
        }

        // Down border line
        $this->arr_output[] = $left.$this->get_down_border().$str_padding_right;

        // Axis X Separators |
        $this->arr_output[] = $left.'  '.$this->get_axis_x_separators().' '.$str_padding_right;
        // Axis X Values
        $this->arr_output[] = $left.' '.$this->get_axis_x_values().$str_padding_right;

        // Axis X Title
        if( $this->get_cfg_param( 'show_x_axis_title' ) ){
            $this->arr_output[] = $left.str_pad($this->get_cfg_param( 'x_axis_title' ), $this->count_data * $this->bar_width + 1 + 2, ' ', STR_PAD_BOTH).$str_padding_right; // +1 = vertical col axis separator, +2 = free space left and right
        }

        
        // Explain Values
        if( $this->get_cfg_param( 'explain_values' ) ){
            $arr_explain = [
				'Max '.max($this->data),
				'Min '.min($this->data),
				'Sum '.number_format($Sum, 2, '.', ''),
				'Avg '.number_format($avg, 2, '.', ''),
				'Median '.number_format($median, 2, '.', ''),
				'Vari '.number_format($vari, 2, '.', ''),
				'Std Dsv '.number_format($std, 2, '.', ''),
				'O ^ Lim '.number_format($this->outl_up_limit, 2, '.', ''),
				'O v Lim '.number_format($this->outl_down_limit, 2, '.', '')
			];
            
            if( $this->get_cfg_param( 'explain_values_same_line' ) ){
                // For compatibility with other functions, we need to cut the line if overrides de width capacity
                $str_cutted = str_pad(implode( ', ', $arr_explain), $this->count_data * $this->bar_width  + 2, ' ', STR_PAD_RIGHT);
                if( strlen($str_cutted) > $this->count_data * $this->bar_width + 2){
                    $str_cutted = substr( $str_cutted, 0, $this->count_data * $this->bar_width + 1);
                    $str_cutted .= chr(27).'[0;31m'.'>'.chr(27).'[0m'.' '; // Indicate that the values continue
                }
                $this->arr_output[] = $left.' '.$str_cutted.$str_padding_right;
            } else {
                foreach( $arr_explain as $explain ){
                    $this->arr_output[] = $left.' '.str_pad($explain, $this->count_data * $this->bar_width + 2, ' ', STR_PAD_RIGHT).$str_padding_right;
                }
            }
        } // /Explain Values

        
        // Padding Bottom
        for( $i=$this->get_cfg_param( 'padding_bottom' ); $i>0; $i-- ){
            $this->arr_output[] = $left.str_pad('', $this->count_data * $this->bar_width + 1 + 2, ' ', STR_PAD_BOTH).$str_padding_right; // +1 = vertical col axis separator, +2 = free space left and right
        }

    } // /prepare_array_output()



    /**
     * Get count(lines) of graph output
     * 
     * return integer $num_lines
     */
    public function count_output_lines(  ){
        return count( $this->arr_output );
    } // /count_output_lines()



    /**
     * Draw Graph
     * 
     * You can draw only 1 line id by $line_id
     * Combine it with $do_line_break = false &, $prepare_array_output = true to prepare 1 time externally & write in each line more than 1 graphs. See example.php
     * 
     * @param integer $line_id
     * @param boolean $do_line_break
     * @param boolean $prepare_array_output
     */
    public function draw( $line_id = null, $do_line_break = true, $prepare_array_output = true ){
        if( $prepare_array_output ){
            $this->prepare_array_output( );
        }

        if( is_null($line_id) ){
            foreach( $this->arr_output as $output_line ){
                echo $output_line;

                if( $do_line_break ){
                    echo PHP_EOL;
                }
            }

        } else {
            echo $this->arr_output[ $line_id ];
            
            if( $do_line_break ){
                echo PHP_EOL;
            }
        }
    } // /draw()



    /**
     * Justify a string
     * 
     * Original:
     * https://www.iteramos.com/pregunta/22339/justificar-cadena-de-algoritmo
     * 
     * @param string $string
     * @param integer $num_chars
     * @return string $justify_string
     */
    private function justify($string, $num_chars){
        $s = trim($string);
        $l = strlen($s);

        if($l >= $num_chars){
            $s = explode("\n", wordwrap($s, $num_chars));
            $s = $s[0];
            $l = strlen($s);
        }

        $c = substr_count($s, ' ');

        if($c === 0) return str_pad($s, $num_chars, ' ', STR_PAD_BOTH);
        
        $a = ($num_chars-$l+$c)/$c;
        $h = floor($a);
        $i = ($a-$h)*$c;
        $w = explode(' ', $s, $i+1);
        $w[$i] = str_replace(' ', str_repeat(' ', $h), $w[$i]);
        
        return implode(str_repeat(' ', ceil($a)), $w);
    }

}// /cli_graph_ml
 ?>