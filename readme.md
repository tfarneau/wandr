# WandR Back

## Routes

- `[POST]` `/api/login`
- `[GET]` `/api/me`
- `[POST]`  `/api/register`
- `[GET]` `/api/checkpoints`
- `[GET]` `/api/itinerary`
- `[GET]` `/api/itineraries`

## Login

**[POST] /api/login** - retourne un token
**[GET] /api/me** - retourne les infos sur l'user

**Pour s'authentifier, soit :**

- Ajouter un header `Authorization : Bearer {token}` à la requête
- Ajouter un param `?token={token}` aux requêtes