# Kucing Aby
## Cara Deploy nya sayang

### 1. Diclone dulu

```zsh
git clone https://github.com/bluebleaze/Kucing.git 
cd Kucing
```

### 2. Install depedencies & Vendor
```zsh
composer install
```

### 3. Ganti .env.exampe ke .env lalu configure
#### Terminal Laragon & Windows CMD:
```zsh
copy .env.example .env
code .env
```

#### Windows powershell, Linux, Macos & Git Bash:
```zsh
cp .env.example .env
code .env
```
### 4. Artisan migrate untuk sinkronisasi Database 
```zsh
php artisan migrate
```
### 5. (Opsional) Tambahkan seeder untuk database dummy
```zsh
php artisan migrate --seed
```
### 6. Run projeknya
```zsh
php artisan serve
```




