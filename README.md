<img width="1884" height="1416" alt="carbon - 2026-10-20T100944 940" src="https://github.com/user-attachments/assets/98b23951-685e-4bcd-98d0-865af3d610ef" />
This file defines the API routing architecture for our application, organized into two security layers: Public Authentication Routes and Protected Resource Routes, wrapped inside a global localization layer.

We wrap all API endpoints inside the localize-api middleware. This dynamically detects the client's language (via the Accept-Language header or a custom parameter) to return localized validation messages and API responses

------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
<img width="1598" height="2644" alt="carbon - 2026-10-20T101343 824" src="https://github.com/user-attachments/assets/eb38eded-b30f-4315-b78f-bcbf20167acc" />

This AuthController strictly follows the Thin Controller Pattern and SOLID Principles. It contains zero business logic and acts solely as an entry point: accepting HTTP requests, validating incoming data through dedicated Form Requests, converting data into DTOs (Data Transfer Objects), and delegating the business execution to an injected Service Layer.

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

<img width="1884" height="1714" alt="carbon - 2026-10-20T101605 452" src="https://github.com/user-attachments/assets/16445a61-5ab0-4b34-8935-9dc1f18e20f5" />

In my UserRegisterRequest, I isolated validation from the controller following the Single Responsibility Principle.
I applied strict database constraints like unique and exists to maintain referential integrity, secured file uploads using MIME validation, and implemented a toDTO() method to transform only the $this->validated() data into a strongly-typed DTO before passing it to the business service.

---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

<img width="2020" height="1676" alt="carbon - 2026-10-20T101719 294" src="https://github.com/user-attachments/assets/17f0b50e-4dd1-4fc7-be45-5c9b18f0be25" />

In this project, I used Data Transfer Objects (DTOs) to achieve strict data encapsulation.
The UserRegisterDTO enforces type safety, casts numeric inputs, and automatically hashes sensitive fields like passwords via a static fromRequest() factory method.
This ensures my Service layer receives clean, validated, and framework-agnostic data structures.

---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

<img width="1108" height="968" alt="carbon - 2026-10-20T101834 417" src="https://github.com/user-attachments/assets/722cee31-d137-40ac-ba7b-4e0a9b1af0d5" />

The IAuthService interface defines registration, login, verification, and code resending functionalities, suggesting an authentication service contract. This interface necessitates concrete implementations to handle user registration, authentication, and verification processes. The methods' signatures (input type array) require further analysis for data structure and validation concerns.

The interface extends the authentication lifecycle with methods for password changes, profile retrieval, profile updates, and logout, indicating a comprehensive user management contract. This design aligns with SOLID principles, promoting loose coupling by allowing swapping of authentication implementations without controller code modifications. The use of interfaces facilitates testability through mocking, allowing isolated verification of authentication logic.

---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

<img width="2048" height="9164" alt="carbon - 2026-10-20T101959 501" src="https://github.com/user-attachments/assets/bb19a1d0-396c-41f3-8e8c-6de1761e5e0e" />

The AuthService is the core business engine of our authentication system. It implements IAuthService as an Abstract Base Class, encapsulating the complete user lifecycle: registration, OTP verification, multi-device token binding, profile management, and session revocation. It guarantees data integrity via ACID Database Transactions and delegates responsibilities to specialized sub-services.

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


<img width="2048" height="2272" alt="carbon - 2026-10-20T102135 595" src="https://github.com/user-attachments/assets/aae15611-d35b-4228-9507-39f0830a7075" />

The provided code snippet defines a AuthWebService class that extends AuthService. It utilizes helper classes for HTTP operations, database interactions, and password hashing functionalities within the App\Architecture\Services\Classes\Auth namespace. The class declaration is incomplete, ending with an opening curly brace.

The login function handles user authentication via mobile number and password. It retrieves the user from the repository, checks for account activation status and password validity, then generates an OTP. In a production environment, this OTP is formatted for SMS delivery. The process is wrapped in a database transaction for atomicity, handling potential exceptions with rollback.

The code within the catch block shows error handling for login failures. Specifically, it logs the failure with file and message identifiers, alongside the exception itself. It then uses a helper to return an error response to the client. This response includes a descriptive message and supporting logs for debugging.

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
<img width="2048" height="2272" alt="carbon - 2026-10-20T102118 434" src="https://github.com/user-attachments/assets/05ddc5c0-42c6-4cdb-a365-cb88aad7b1e6" />


The AuthMobileService is the dedicated mobile implementation of our abstract AuthService. It provides a specialized authentication strategy tailored specifically for Mobile Applications (iOS & Android), allowing mobile-specific requirements (like Device Token registration and OTP flows) to evolve independently from web clients.

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

<img width="2048" height="2570" alt="carbon - 2026-10-20T102338 670" src="https://github.com/user-attachments/assets/5eba006b-0641-4f5c-baa9-f3f1b8b0b2a6" />

The SERVICES constant defines a mapping between service interfaces and their implementations for different platforms (website, mobile). The detectPlatform method determines the appropriate implementation based on the incoming request's URL path. Within the register method, the service implementations are bound to their respective interfaces in the service container using a singleton scope. The detectPlatform method appears to be incomplete, lacking platform detection logic beyond the "website" and "mobile" routes.

The detectPlatform method resolves concrete service implementations based on the detected platform; the code snippet indicates potential extensibility for further platforms. Singleton scope ensures service instances are reused, optimizing resource consumption and avoiding redundant object creation. This architecture enables dynamic injection of platform-specific services at runtime, improving maintainability through a configuration-driven approach.

---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

<img width="1698" height="1862" alt="carbon - 2026-10-20T102512 467" src="https://github.com/user-attachments/assets/909ee6ec-2766-45d7-9744-8d2c4a274a90" />

Interface IAbstractRepository is provided, defining a contract. Its primary method is prepareQuery(), suggesting a focus on query construction within the repository pattern. The comment "Basic CRUD" indicates this interface likely serves as the foundation for Create, Read, Update, and Delete operations.

The IAbstractRepository interface defines methods for common database operations, confirming its role as a data access abstraction within the repository pattern. The inclusion of create, insert, update, destroy, and related methods supports the expected CRUD functionality, which is the cornerstone for managing entities. Further query helpers like all, withTrashed, and getData provide flexible data retrieval capabilities.

The IAbstractRepository is the cornerstone of a data access abstraction, isolating business logic from specific database interactions. It provides a standardized contract for CRUD operations, soft deletes, and bulk operations to enhance reusability and maintainability. Its flexible query engine supports complex data retrieval needs through filtering, eager loading, and pagination.

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


<img width="2048" height="5960" alt="carbon - 2026-10-20T102501 868" src="https://github.com/user-attachments/assets/81d4b03d-4148-4035-9c4f-9b6f51b40634" />

The AbstractRepository acts as the base engine for our Data Access Layer.
It injects any Eloquent model polymorphically, reducing repetitive boilerplate queries across our application.
It incorporates enterprise optimizations, such as caching dynamic pagination limits for 7 days, providing dedicated bulk operations (insert and massDelete), and integrating a flexible getData() method designed to eliminate the N+1 query problem via eager-loading

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


