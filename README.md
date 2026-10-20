<img width="1884" height="1416" alt="carbon - 2026-10-20T100944 940" src="https://github.com/user-attachments/assets/98b23951-685e-4bcd-98d0-865af3d610ef" />
This file defines the API routing architecture for our application, organized into two security layers: Public Authentication Routes and Protected Resource Routes, wrapped inside a global localization layer.

We wrap all API endpoints inside the localize-api middleware. This dynamically detects the client's language (via the Accept-Language header or a custom parameter) to return localized validation messages and API responses

------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
<img width="1598" height="2644" alt="carbon - 2026-10-20T101343 824" src="https://github.com/user-attachments/assets/eb38eded-b30f-4315-b78f-bcbf20167acc" />

This AuthController strictly follows the Thin Controller Pattern and SOLID Principles. It contains zero business logic and acts solely as an entry point: accepting HTTP requests, validating incoming data through dedicated Form Requests, converting data into DTOs (Data Transfer Objects), and delegating the business execution to an injected Service Layer.
