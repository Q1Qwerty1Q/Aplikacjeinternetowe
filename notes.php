<?php

$filename = "notes.txt";

function showMenu() {
    echo "\n===== SYSTEM NOTATEK =====\n";
    echo "1. Dodaj nową notatkę\n";
    echo "2. Wyświetl wszystkie notatki\n";
    echo "3. Usuń wszystkie notatki\n";
    echo "4. Zakończ program\n";
    echo "Wybierz opcję: ";
}

function addNote($filename) {
    echo "Wpisz treść notatki: ";
    $note = trim(fgets(STDIN));

    if (empty($note)) {
        echo "Notatka nie może być pusta!\n";
        return;
    }

    $date = date("Y-m-d H:i:s");
    $entry = "[$date] $note" . PHP_EOL;

    if (file_put_contents($filename, $entry, FILE_APPEND) === false) {
        echo "Błąd: Nie udało się zapisać notatki!\n";
    } else {
        echo "Notatka została dodana.\n";
    }
}

function showNotes($filename) {
    if (!file_exists($filename) || filesize($filename) == 0) {
        echo "Brak notatek do wyświetlenia.\n";
        return;
    }

    $lines = file($filename, FILE_IGNORE_NEW_LINES);

    if ($lines === false) {
        echo "Błąd: Nie można odczytać pliku.\n";
        return;
    }

    echo "\n===== LISTA NOTATEK =====\n";
    foreach ($lines as $index => $line) {
        echo ($index + 1) . ". " . $line . "\n";
    }
}

function deleteNotes($filename) {
    if (!file_exists($filename)) {
        echo "Plik nie istnieje — brak notatek do usunięcia.\n";
        return;
    }

    
    if (file_put_contents($filename, "") === false) {
        echo "Błąd: Nie udało się usunąć notatek.\n";
    } else {
        echo "Wszystkie notatki zostały usunięte.\n";
    }
}


while (true) {
    showMenu();
    $choice = trim(fgets(STDIN));

    switch ($choice) {
        case "1":
            addNote($filename);
            break;
        case "2":
            showNotes($filename);
            break;
        case "3":
            deleteNotes($filename);
            break;
        case "4":
            echo "Zamykanie programu...\n";
            exit;
        default:
            echo "Nieprawidłowa opcja. Spróbuj ponownie.\n";
    }
}