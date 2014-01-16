<?php

/**
 * Script contains two implementations of the algorithm for comparing:
 * 1) works with the O(n^2) complexity;
 * 2) works with the O(n) complexity.
 * 
 * If to generate two arrays with 10000 elements capacity the execution time differs
 * a lot:
 * O(n^2): 33.17 s
 * O(n): 0.02 s
 */


/**
 * O(n^2) implementation
 * 
 * @param array $A
 * @param array $B
 * @return array
 */
function array_difference_on2( array $A, array $B ){
    $A_diff_to_B = $B_diff_to_A = [];
    
    $is_common = false;
    foreach ( $A as $A_value ){
        foreach ( $B as $B_value ){
            if( $A_value === $B_value ){
                $is_common = true;
            }
        }
        
        if( !$is_common ){
            $A_diff_to_B[] = $A_value;
        }
        $is_common = false;
    }
    
    $is_common = false;
    foreach ( $B as $B_value ){
        foreach ( $A as $A_value ){
            if( $B_value === $A_value ){
                $is_common = true;
            }
        }
        
        if( !$is_common ){
            $B_diff_to_A[] = $B_value;
        }
        $is_common = false;
    }
    
    return array( "A - B" => $A_diff_to_B, "B - A" => $B_diff_to_A );
}

/**
 * O(n) implementation
 * 
 * @param array $A
 * @param array $B
 * @return array
 */
function array_difference_on( array $A, array $B ){
    $A_diff_to_B = $B_diff_to_A = [];
    
    $summarized_unique_array = [];
    foreach ( $A as $value ){
        $summarized_unique_array[ $value ] = $value;
    }
    
    foreach ( $B as $value ){
        if( !isset( $summarized_unique_array[ $value ] ) ){
            $summarized_unique_array[ $value ] = $value;
        }else{
            unset( $summarized_unique_array[ $value ] );
        }
    }
    
    foreach ( $A as $value ){
        if( isset( $summarized_unique_array[ $value ] ) ){
            $A_diff_to_B[] = $value;
        }
    }
    
    foreach ( $B as $value ){
        if( isset( $summarized_unique_array[ $value ] ) ){
            $B_diff_to_A[] = $value;
        }
    }
    
    return array( "A - B" => $A_diff_to_B, "B - A" => $B_diff_to_A );
}

$A = [ 1, 2, 3, 8, 9 ];
$B = [ 2, 5, 9, 10, 12, 14 ];

//$A = $B = [];
//for( $i = 0; $i < 10000; $i++ ){
//    $A[] = rand( 0, 10000 );
//    $B[] = rand( 0, 10000 );
//}
//sort($A);
//sort($B);
//$A = array_unique($A);
//$B = array_unique($B);

//O(n^2) measuring
$start = microtime(true);
$differences = array_difference_on2( $A, $B );
print "O(n^2): " . round( microtime(true) - $start, 2 ) . " s" . PHP_EOL;
foreach ( $differences as $key => $difference ){
    print "{ $key } - " . implode( " ", $difference ) . PHP_EOL;
}

//O(n) measuring
$start = microtime(true);
$differences = array_difference_on( $A, $B );
print "O(n): " . round( microtime(true) - $start, 2 ) . " s" . PHP_EOL;
foreach ( $differences as $key => $difference ){
    print "{ $key } - " . implode( " ", $difference ) . PHP_EOL;
}
