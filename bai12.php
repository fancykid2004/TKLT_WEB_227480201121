<!DOCTYPE html>
<html>
<head>
    <title>Bàn cờ vua</title>
    <meta charset="UTF-8">
    <style>
        .chess-board {
            border: 2px solid #333;
            display: inline-block;
        }
        .chess-row {
            display: flex;
        }
        .chess-cell {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }
        .white {
            background-color: #f0d9b5;
        }
        .black {
            background-color: #b58863;
        }
    </style>
</head>
<body>
    <h1>Bàn cờ vua</h1>
    
    <div class="chess-board">
        <?php
        $pieces = [
            ['♜', '♞', '♝', '♛', '♚', '♝', '♞', '♜'],
            ['♟', '♟', '♟', '♟', '♟', '♟', '♟', '♟'],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            ['♙', '♙', '♙', '♙', '♙', '♙', '♙', '♙'],
            ['♖', '♘', '♗', '♕', '♔', '♗', '♘', '♖']
        ];
        
        for ($row = 0; $row < 8; $row++) {
            echo '<div class="chess-row">';
            for ($col = 0; $col < 8; $col++) {
                $color = ($row + $col) % 2 == 0 ? 'white' : 'black';
                echo '<div class="chess-cell ' . $color . '">' . $pieces[$row][$col] . '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>