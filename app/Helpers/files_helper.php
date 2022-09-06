<?php

function deleteFile(string $filePath): bool{
    if(is_file($filePath)){
        unlink($filePath);
        return true;
    } else {
        return false;
    }
}