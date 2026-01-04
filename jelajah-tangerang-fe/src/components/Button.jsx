import { clsx } from "clsx";

const Button = ({ children, variant = "primary", className, ...props }) => {
  const baseStyle =
    "px-6 py-2 rounded-lg font-semibold transition-all duration-300";
  const variants = {
    primary: "bg-primary text-white hover:bg-blue-700",
    accent: "bg-accent text-white hover:bg-orange-600",
    outline:
      "border-2 border-primary text-primary hover:bg-primary hover:text-white dark:border-white dark:text-white dark:hover:bg-white dark:hover:text-black",
  };

  return (
    <button
      className={clsx(baseStyle, variants[variant], className)}
      {...props}
    >
      {children}
    </button>
  );
};

export default Button;
