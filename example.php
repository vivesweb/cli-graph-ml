<?php

/** example.php of cli-graph-ml.class.php
 *  
 * Class for visualize data in bar graph & detect outliers * 
 * 
 * @author Rafael Martin Soto
 * @author {@link https://www.inatica.com/ Inatica}
 * @blog {@link https://rafamartin10.blogspot.com/ Blog Rafael Martin Soto}
 * @since September 2021
 * @version 1.0.0
 * @license GNU General Public License v3.0
 * 
 * @param string $data
 * @param array $axis_x_values
 * @param array $axis_y_values
 * @param string $config
 * 
 */

 require_once( 'cli-graph-ml.class.php' );

 /* You can define a custom $config
 $config = [
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
 */

 $config = [];
 

$arr_val_example_1 = [  1,2,5,6,7,9,12,15,18,19,38 ];
$axis_x_values = [ 'Jan', 'Jun', 'Dec' ];

$bar_graph = new cli_graph_ml( $arr_val_example_1, $axis_x_values, $config );
$bar_graph->set_title( 'Months in %' );

// Draw with defaults
echo 'Defaults Bar Graph'.PHP_EOL;
$bar_graph->draw();


// Draw with bar width 2
$bar_width = 2;
echo 'Bar Width '.$bar_width.PHP_EOL;
$bar_graph->set_bar_width( $bar_width );
$bar_graph->set_bar_color( 'blue' );
$bar_graph->set_explain_values_same_line( true );
$bar_graph->draw();


// Draw with bar width 4
$bar_width *= 2;
echo 'Bar Width '.$bar_width.PHP_EOL;
$bar_graph->set_bar_width( $bar_width );
$bar_graph->set_explain_values( false );
$bar_graph->set_bar_color( 'magenta' );
$bar_graph->set_underlines_every( 2 );
$bar_graph->draw();


// Draw with bar width 8
$bar_width *= 2;
echo 'Bar Width '.$bar_width.PHP_EOL;
$bar_graph->set_bar_width( $bar_width );
$bar_graph->set_explain_values( true );
$bar_graph->set_bar_color( 'yellow' );
$bar_graph->set_underlines_every( 3 );
$bar_graph->draw();

// Draw without underlines, Graph Lenght 20 & with bar width 16
$bar_width *= 2;
echo 'Remove underlines'.PHP_EOL;
$bar_graph->set_bar_width( $bar_width );
$bar_graph->set_draw_underlines( false );
$bar_graph->set_bar_color( 'green' );
$bar_graph->set_graph_length( 20 );
$bar_graph->draw();

unset( $bar_graph );

// draw 3 graphs floating
$arr_val_example_2 = [  7,7,6,3,5,8,0,10,8,9,3 ];
$arr_val_example_3 = [  11,22,55,60,70,90,120,150,180,190,380 ];
$axis_x_values = [ 'Jan', 'Jun', 'Dec' ];

$bar_graph = [];

$bar_graph[] = new cli_graph_ml( $arr_val_example_1, $axis_x_values, $config );
$bar_graph[0]->set_title( 'Months 1 in %' );

$bar_graph[] = new cli_graph_ml( $arr_val_example_2, $axis_x_values, $config );
$bar_graph[1]->set_title( 'Months 2 in %' );

$bar_graph[] = new cli_graph_ml( $arr_val_example_3, $axis_x_values, $config );
$bar_graph[2]->set_title( 'Months 3 in %' );

// Prepare on each graph
foreach( $bar_graph as$graph){
    $graph->prepare_array_output( );
}

// draw on each graph each line
// IMPORTANT: All graphs will need to have the same number of Lines
// We take a counter of lines of the first graph. We assume all have the same
$count_output_lines = $bar_graph[0]->count_output_lines();

for( $i = 0; $i< $count_output_lines; $i++ ){
    foreach( $bar_graph as $graph){
        $graph->draw( $i, false, false); // Draw line $i, dont do line break and do not do prepare
    }

    echo PHP_EOL; // for get new line
}
