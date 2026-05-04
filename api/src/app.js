import cors from 'cors';
import helmet from 'helmet';
import morgan from 'morgan';
import express from 'express';
//import categoriesRouter from './routes/categories.routes.js';
import authRouter from './routes/auth.routes.js';
import productsRouter from './routes/products.routes.js';
import notFound from './middlewares/not-found.js';
import errorHandler from './middlewares/error-handler.js';
import swaggerUi from 'swagger-ui-express';
import { swaggerSpec } from './swagger.js';
import { requireAuth } from './middlewares/require-auth.js';
//import collectionsRouter from './routes/collections.routes.js';
//import suppliersRoutes from './routes/suppliers.routes.js';



const app = express();

app.use(helmet());
app.use(cors());
app.use(morgan('dev'));
app.use(express.json());

app.get('/health', (_req, res) => {
  res.status(200).json({ status: 'ok' });
});
app.use('/api/v1/auth', authRouter);
app.use('/api/v1/products', requireAuth, productsRouter);


app.use('/api-docs', (_req, res, next) => {
    res.removeHeader('Content-Security-Policy');
    next();
  });
app.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec));

app.use(notFound);
app.use(errorHandler);

export default app;