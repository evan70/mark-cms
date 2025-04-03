#!/bin/bash

# Clear view cache
rm -rf storage/cache/views/*

# Run PHP cache clearer
php public/clear-cache.php

echo "Cache cleared successfully!"
