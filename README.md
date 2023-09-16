## Routes

- **GET /buckets**: View all buckets.
- **GET /buckets/create**: Create a new bucket (form).
- **POST /buckets**: Store a new bucket.
- **GET /buckets/{bucket}**: View details of a specific bucket.
- **GET /balls**: View all balls.
- **GET /balls/create**: Create a new ball (form).
- **POST /balls**: Store a new ball.
- **POST /buckets/suggest**: Get suggestions for placing balls in buckets.

## Functionality

### Bucket Management

- **View all buckets**: Access the list of all existing buckets.
- **Create a new bucket**: Create a new bucket by specifying a name and capacity.
- **View bucket details**: Check the details of a specific bucket, including its capacity and filled value.

### Ball Management

- **View all balls**: See the list of all added balls.
- **Create a new ball**: Add a new ball with a color and size.

### Suggest Buckets for Balls

- Use the /buckets/suggest route to get suggestions for placing balls in buckets efficiently.
- Specify the quantities of each ball, and the system will suggest the best buckets for placement, considering the bucket capacities and available space.

## Models

- **Bucket**: Represents a bucket with attributes such as name, capacity, and filled_value.
- **Ball**: Represents a ball with attributes like color and size.

## Database

The application uses a MySQL database with the following tables:

- **buckets**: Stores information about buckets, including id, name, capacity, filled_value, and timestamps.
- **balls**: Contains data for balls, including id, color, size, and timestamps.
