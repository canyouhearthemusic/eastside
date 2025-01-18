## Тестовое задание было написано используя Модульную и Чистую архитектуру.

## Функционал


https://github.com/user-attachments/assets/7d60b85b-ec3f-4f14-b288-e669726a8e67



https://github.com/user-attachments/assets/46748b4e-d1b2-4534-9eba-9aec6d327089


- **Аутентификация пользователей**: По email и паролю.
- **Управление постами**:
    - Создание, обновление, удаление постов.
    - Только автор поста может редактировать или удалять свои посты.
    - Посты содержат название, описание, MP3 файл, временные метки и статус (активен/неактивен).
- **Теги**:
    - Прикрепление множества тегов к постам.
    - Фильтрация постов по тегам.
- **Сжатие MP3**: Автоматическое сжатие MP3 файлов до 128 кб/с при загрузке.
- **Пагинация, фильтрация и сортировка**: Для всех сущностей.
- **Docker**: Конфигурация Docker и Docker Compose для простого развёртывания.
- **Документация API**: С использованием Swagger (OpenAPI).

### Требования

- Docker и Docker Compose
- Composer

### Установка

```
git clone https://github.com/canyouhearthemusic/eastside.git
cd eastside

# macOS and Linux
cp Application/.env.example Application/.env

# Windows
copy Application/.env.example Application/.env
```

Запускаем команду, которая скачает все зависимости, и поднимет приложение. *Можете открыть Makefile для более подробной
информации о скрипте*

```
make all
```

### Swagger: http://localhost/api/swagger

Затем переходим в проект и открываем `Application/resources/postman`
находим эндпоинт `/auth/login` и отправляем запрос с телом:

```json
{
  "email": "johndoe@example.com",
  "password": "johndoe123"
}
```

получаем accessToken и сохраняем его в токен коллекции:
<img width="1512" alt="image" src="https://github.com/user-attachments/assets/55976c02-a8d8-4d06-8bbe-9277c3718574" />

Реализованы все эндпоинты, для задания. Вплоть до проигрыша `audio/mpeg` файлов.

## **ВАЖНО!**
В папке `Application/resources/mpeg` есть аудиофайл `audio.mp3`. Можете использовать его в качестве тестового файла при создании/обновлении Поста.

Для обратной связи [TG](https://t.me/al1bekkkk)
